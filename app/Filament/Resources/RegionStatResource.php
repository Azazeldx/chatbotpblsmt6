<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RegionStatResource\Pages;
use App\Models\RegionStat;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class RegionStatResource extends Resource
{
    protected static ?string $model = RegionStat::class;

    protected static ?string $navigationIcon = 'heroicon-o-chart-bar-square';

    protected static ?string $navigationGroup = 'Profil Daerah';

    protected static ?string $navigationLabel = 'Indikator Makro';

    protected static ?string $modelLabel = 'Indikator Makro';

    protected static ?string $pluralModelLabel = 'Indikator Makro';

    protected static ?int $navigationSort = 1;

    /** Hanya Super Admin (dan Developer) yang boleh mengakses & mengubah. */
    public static function canAccess(): bool
    {
        return Auth::user()?->hasRole(['Superadmin', 'Developer']) ?? false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('label')
                    ->label('Label')
                    ->placeholder('mis. Ekonomi, IPM, Kemiskinan')
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('value')
                    ->label('Nilai')
                    ->placeholder('mis. 5,85% atau 75,50')
                    ->helperText('Tulis apa adanya termasuk tanda % bila perlu.')
                    ->required()
                    ->maxLength(255),

                Forms\Components\ColorPicker::make('color')
                    ->label('Warna Angka')
                    ->default('#2563eb')
                    ->required(),

                Forms\Components\TextInput::make('sort_order')
                    ->label('Urutan')
                    ->numeric()
                    ->default(0),

                Forms\Components\Toggle::make('is_active')
                    ->label('Tampilkan di beranda')
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
                Tables\Columns\TextColumn::make('label')
                    ->label('Label')
                    ->searchable(),
                Tables\Columns\TextColumn::make('value')
                    ->label('Nilai')
                    ->weight('bold'),
                Tables\Columns\ColorColumn::make('color')
                    ->label('Warna'),
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
            'index' => Pages\ManageRegionStats::route('/'),
        ];
    }
}
