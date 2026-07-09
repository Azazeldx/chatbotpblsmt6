<?php

namespace App\Filament\Resources;

use App\Filament\Forms\CustomForms;
use Illuminate\Support\Str;
use App\Filament\Resources\ArticleResource\Pages;
use App\Models\Article;
use App\Models\GeneralSetting;
use App\Models\Sponsor;
use App\Models\Category;
use Awcodes\Curator\Components\Forms\CuratorPicker;
use Filament\Forms;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use FilamentTiptapEditor\TiptapEditor;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Http;

class ArticleResource extends Resource
{
    protected static ?string $model = Article::class;

    protected static ?string $navigationGroup = 'Article';
    protected static ?int $navigationSort  = 1;

    protected static ?string $navigationIcon = 'heroicon-o-pencil';

    public static function getCleanOptionString(Model $data): string
    {
        return view('filament.components.select_option_image')
            ->with('image', $data->image?->path)
            ->with('label', $data->category->category_name." - ".$data->title)
            ->render();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Tabs::make('Tabs')
                    ->tabs([
                        Forms\Components\Tabs\Tab::make('Application')
                            ->icon('heroicon-o-tv')
                            ->schema([
                                Forms\Components\Section::make()
                                    ->schema([
                                        Forms\Components\Textarea::make('title')
                                            ->unique('articles', 'title', ignoreRecord: true)
                                            ->rows(3)
                                            ->required()
                                            ->maxLength(255)
                                            ->reactive()
                                            ->debounce(1000)
                                            ->afterStateUpdated(function (callable $set, $state) {
                                                $set('slug', Str::slug($state));
                                            }),
                                        Forms\Components\Textarea::make('slug')
                                            ->required()
                                            ->rows(3)
                                            ->unique(ignoreRecord: true)
                                            ->maxLength(255)
                                            ->regex('/^[a-z0-9-]+$/'),
                                        CuratorPicker::make('cover_id')
                                            ->label('Cover')
                                            ->buttonLabel('Pilih / Ganti Cover')
                                            ->required()
                                            ->relationship('cover', 'id'),
                                    ])
                                    ->columns(1)
                                    ->columnSpan(['lg' => 2]),
                                Forms\Components\Section::make()
                                    ->schema([
                                        Forms\Components\Select::make('category_id')
                                            ->required()
                                            // ->disabledOn('edit')
                                            ->live()
                                            ->relationship(
                                                'category',
                                                'category_name',
                                                fn (Builder $query) => $query->whereNotIn('slug', ['event', 'departemen'])
                                            ),
                                        Forms\Components\Select::make('tags')
                                            ->multiple()
                                            ->relationship('tags', 'tag_name')
                                            ->createOptionForm([
                                                Forms\Components\TextInput::make('tag_name')
                                                    ->required()
                                                    ->maxLength(255)
                                                    ->unique(column: 'tag_name')
                                                    ->label('Tag name'),
                                            ])
                                            ->searchable(),
                                        Forms\Components\Select::make('sponsors')
                                            ->multiple()
                                            ->relationship('sponsors')
                                            ->allowHtml()
                                            ->options(fn () => Sponsor::all()
                                                ->mapWithKeys(fn ($item) => [
                                                    $item->id => static::getCleanOptionString($item)
                                                ])
                                                ->toArray(),
                                            )
                                            ->getSearchResultsUsing(function (string $query) {
                                                $sponsors = Sponsor::where('title', 'like', "%{$query}%")->limit(25)->get();
                                                return $sponsors->mapWithKeys(fn ($item) => [
                                                    $item->id => static::getCleanOptionString($item)
                                                ])
                                                ->toArray();
                                            })
                                            ->getOptionLabelUsing(function ($value): string {
                                                return Sponsor::find($value)
                                                    ->mapWithKeys(fn ($item) => [
                                                        $item->id => static::getCleanOptionString($item)
                                                    ])
                                                    ->toArray();
                                            })
                                            ->searchable()
                                            ->visible(function () {
                                                $data = GeneralSetting::first()?->toArray() ?: [];
                                                return $data['features']['sponsors'];
                                            }),
                                        Forms\Components\Toggle::make('private'),
                                    ])
                                    ->columns(1)
                                    ->columnSpan(['lg' => 1]),
                            ])
                            ->columns(3),
                        Forms\Components\Tabs\Tab::make('Content')
                            ->icon('heroicon-o-pencil')
                            ->schema([
                                Textarea::make('preview_content'),
                                TiptapEditor::make('content')
                                    ->profile('default')
                                    ->hintAction(
                                        Action::make('Generate')
                                            ->label('Generate')
                                            ->icon('heroicon-o-sparkles')
                                            ->hidden(!(config('general-settings.features.ai', false)))
                                            ->disabled(function ($get) {
                                                return !$get('title') || !$get('cover_id');
                                            })
                                            ->tooltip('Klik untuk generate artikel beserta SEO berdasarkan judul dan gambar kover')
                                            ->form([
                                                Textarea::make('prompt'),
                                            ])
                                            ->action(function (array $data, $get, $set) {
                                                $title = $get('title');
                                                $prompt = $data['prompt'];
                                                $cover = $get('cover_id');
                                                $cover = reset($cover);
                                                $cover = $cover['path'] ?? null;

                                                try {
                                                    $res = app(\App\Http\Controllers\ChatbotController::class)->generateArticle($title, $cover, $prompt);

                                                    $set('content', $res[0] ?? 'Gagal');
                                                    $set('preview_content', $res[1] ?? 'Gagal');
                                                    $set('metadata.meta_title', $res[2] ?? 'Gagal');
                                                    $set('metadata.meta_desc', $res[3] ?? 'Gagal');

                                                    Notification::make()
                                                        ->success()
                                                        ->title('Berhasil generate artikel')
                                                        ->send();

                                                } catch (\Throwable $e) {
                                                    Notification::make()
                                                        ->danger()
                                                        ->title('Gagal memanggil API')
                                                        ->body($e->getMessage())
                                                        ->send();
                                                }
                                            })
                                    ),
                            ])
                            ->columns(1),
                        Forms\Components\Tabs\Tab::make('SEO')
                            ->icon('heroicon-o-window')
                            ->schema([
                                Forms\Components\TextInput::make('meta_title')
                                    ->maxLength(255),
                                Forms\Components\Textarea::make('meta_desc')
                                    ->label('Meta Description')
                                    ->rows(5)
                                    ->columnSpanFull(),
                            ])
                            ->columns(2)
                            ->statePath('metadata'),
                        Forms\Components\Tabs\Tab::make('Fields')
                            ->icon('heroicon-o-plus')
                            ->visible(
                                function ($record, $get) {
                                    $fields = Category::query()
                                        ->where('id', $get('category_id'))
                                        ->whereNotNull('fields')
                                        ->value('fields');
                                    return !empty($fields);
                                }
                            )
                            ->schema(
                                function ($record, $get) {
                                    $fields = Category::query()
                                        ->where('id', $get('category_id'))
                                        ->whereNotNull('fields')
                                        ->value('fields');
                                    return $fields ? CustomForms::get($fields) : [];
                                }
                            )
                            ->columns(2)
                            ->statePath('fields'),
                    ])
                    ->columnSpan(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->groups([
                'creator.name',
                'editor.name'
            ])
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->limit(50)
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('category.category_name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('published_at')
                    ->dateTime()
                    ->sortable()
                    ->searchable(),
                Tables\Columns\IconColumn::make('private')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('creator.name')
                    ->label('Created by')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('editor.name')
                    ->label('Last edited by')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category')->relationship('category', 'category_name'),
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('publish')
                    ->label('Publish')
                    ->action(function ($record) {
                        $record->update([
                            'published_at' => now(),
                        ]);
                        Notification::make()
                            ->title('Published')
                            ->success()
                            ->send();
                    })
                    ->visible(fn ($record) => empty($record->published_at)),
                Tables\Actions\Action::make('unpublish')
                    ->label('Unpublish')
                    ->action(function ($record) {
                        $record->update([
                            'published_at' => null,
                        ]);
                        Notification::make()
                            ->title('Unpublished')
                            ->success()
                            ->send();
                    })
                    ->visible(fn ($record) => $record->published_at),
                Tables\Actions\Action::make('private')
                    ->label('Private')
                    ->action(function ($record) {
                        $record->update([
                            'privated' => 1,
                        ]);
                        Notification::make()
                            ->title('Privated')
                            ->success()
                            ->send();
                    })
                    ->visible(fn ($record) => !$record->privated),
                Tables\Actions\Action::make('unprivate')
                    ->label('Unprivate')
                    ->action(function ($record) {
                        $record->update([
                            'privated' => 0,
                        ]);
                        Notification::make()
                            ->title('Unprivaated')
                            ->success()
                            ->send();
                    })
                    ->visible(fn ($record) => $record->privated),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ForceDeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListArticles::route('/'),
            'create' => Pages\CreateArticle::route('/create'),
            'edit' => Pages\EditArticle::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
