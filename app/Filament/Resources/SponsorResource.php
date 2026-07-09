<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SponsorResource\Pages;
use App\Models\GeneralSetting;
use App\Models\Sponsor;
use Awcodes\Curator\Components\Forms\CuratorPicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Split;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class SponsorResource extends Resource
{
    protected static ?string $model = Sponsor::class;

    protected static ?string $navigationGroup = 'Sponsors';
    protected static ?int $navigationSort  = 1;

    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Split::make([
                    section::make()
                        ->schema([
                            CuratorPicker::make('image_id')
                                ->label('Image')
                                ->required()
                        ])
                        ->columns(1)
                        ->grow(true),
                    Section::make()
                        ->schema([
                            TextInput::make('title')
                                ->required()
                                ->maxLength(255),
                            Select::make('category')
                                ->relationship('category', 'category_name')
                                ->createOptionForm([
                                    TextInput::make('category_name')
                                        ->required()
                                        ->maxLength(255)
                                        ->unique(column: 'category_name')
                                        ->label('Category name'),
                                    TextInput::make('sort_order')
                                        ->required()
                                        ->numeric()
                                        ->default(0),
                                ])
                                ->preload()
                                ->searchable()
                                ->required()
                                ->label('Category'),
                            Toggle::make('featured')
                                ->default(0),
                        ])
                        ->columns(1)
                        ->grow(false)
                    ])
                ->columns(['default' => 1, 'lg' => 3]),
            ])
            ->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->groups([
                'category.category_name',
                'creator.name',
                'editor.name'
            ])
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\ImageColumn::make('image.path')
                    ->label('Image'),
                Tables\Columns\TextColumn::make('category.category_name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\IconColumn::make('featured')
                    ->boolean(),
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
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageSponsors::route('/'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function canAccess(): bool
    {
        return Auth::user()->can('view_sponsor') ? config('general-settings.features.sponsors', false) : false;
    }
}
