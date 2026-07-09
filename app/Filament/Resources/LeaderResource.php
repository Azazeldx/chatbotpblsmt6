<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LeaderResource\Pages;
use App\Models\Leader;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class LeaderResource extends Resource
{
    protected static ?string $model = Leader::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationGroup = 'Profil Daerah';

    protected static ?string $navigationLabel = 'Pemimpin Daerah';

    protected static ?string $modelLabel = 'Pemimpin Daerah';

    protected static ?string $pluralModelLabel = 'Pemimpin Daerah';

    protected static ?int $navigationSort = 2;

    /** Hanya Super Admin (dan Developer) yang boleh mengakses & mengubah. */
    public static function canAccess(): bool
    {
        return Auth::user()?->hasRole(['Superadmin', 'Developer']) ?? false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\FileUpload::make('photo')
                    ->label('Foto')
                    ->image()
                    ->avatar()
                    ->imageEditor()
                    ->disk('public')
                    ->directory('leaders')
                    ->helperText('Kosongkan untuk memakai avatar otomatis dari nama.')
                    ->columnSpanFull(),

                Forms\Components\TextInput::make('name')
                    ->label('Nama')
                    ->placeholder('Nama lengkap pejabat')
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('position')
                    ->label('Jabatan')
                    ->placeholder('mis. Bupati, Wakil Bupati, Sekretaris Daerah')
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('term')
                    ->label('Masa Bakti')
                    ->placeholder('mis. 2025 - 2030')
                    ->maxLength(255),

                Forms\Components\TextInput::make('sort_order')
                    ->label('Urutan')
                    ->numeric()
                    ->default(0),

                Forms\Components\Toggle::make('is_active')
                    ->label('Tampilkan')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->columns([
                Tables\Columns\TextColumn::make('sort_order')
                    ->label('Urutan')
                    ->sortable(),
                Tables\Columns\ImageColumn::make('photo')
                    ->label('Foto')
                    ->disk('public')
                    ->circular()
                    ->defaultImageUrl(fn(Leader $record) => $record->photo_url),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('position')
                    ->label('Jabatan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('term')
                    ->label('Masa Bakti'),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Diperbarui')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageLeaders::route('/'),
        ];
    }
}
