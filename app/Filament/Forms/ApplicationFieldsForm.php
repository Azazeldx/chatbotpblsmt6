<?php

namespace App\Filament\Forms;

use Dotswan\MapPicker\Fields\Map;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;

class ApplicationFieldsForm
{
    public static function get(): array
    {
        return [
            Grid::make()
                ->schema([
                    Section::make('Site Config')
                        ->schema([
                            TextInput::make('site_name')
                                ->autofocus(),
                            Textarea::make('site_description'),
                            FileUpload::make('site_logo')
                                ->image()
                                ->disk('public')
                                ->directory('assets'),
                            FileUpload::make('site_favicon')
                                ->image()
                                ->disk('public')
                                ->directory('assets')
                                ->acceptedFileTypes(['image/x-icon', 'image/vnd.microsoft.icon']),
                        ])
                        ->columns(1),
                    Section::make('Location')
                        ->schema([
                            TextInput::make('address')
                                ->maxLength(255),
                            TextInput::make('url')
                                ->url(),
                            Map::make('coordinate')
                                ->zoom(15)
                                ->minZoom(0)
                                ->maxZoom(28)
                                ->tilesUrl("https://tile.openstreetmap.de/{z}/{x}/{y}.png")
                                ->detectRetina(true)
                                ->showFullscreenControl(true)
                                ->showZoomControl(true)
                                ->extraStyles(['min-height: 50dvh']),
                        ])
                        ->columns(1)
                        ->statePath('location'),
                ])
                ->columnSpan(['lg' => 2]),
            Grid::make()
                ->schema([
                    Section::make('Urls')
                        ->schema([
                            TextInput::make('site_url')
                                ->url()
                                ->placeholder('https://site.com'),
                            TextInput::make('site_dashboard_url')
                                ->prefix('/'),
                        ]),
                    Section::make('Contact Supports')
                        ->schema([
                            TextInput::make('email')
                                ->email()
                                ->prefixIcon('heroicon-o-envelope'),
                            TextInput::make('phone')
                                ->prefixIcon('heroicon-o-phone'),
                        ])
                        ->statePath('contacts'),
                    Section::make('Theme')
                        ->schema([
                            ColorPicker::make('primary')
                                ->rgb()
                                ->regex('/^rgb\((\d{1,3}),\s*(\d{1,3}),\s*(\d{1,3})\)$/'),
                            ColorPicker::make('secondary')
                                ->rgb()
                                ->regex('/^rgb\((\d{1,3}),\s*(\d{1,3}),\s*(\d{1,3})\)$/'),
                            ColorPicker::make('tertiary')
                                ->rgb()
                                ->regex('/^rgb\((\d{1,3}),\s*(\d{1,3}),\s*(\d{1,3})\)$/'),
                        ])
                        ->statePath('theme'),
                    Section::make('Features')
                        ->description('Features you want to have.')
                        ->schema([
                            Toggle::make('google_analytics'),
                            Toggle::make('ai')
                                ->label('AI'),
                            Toggle::make('sponsors'),
                            // Toggle::make('testimonials')
                            //     ->disabled(),
                            // Toggle::make('ticketings')
                            //     ->disabled(),
                        ])
                        ->live()
                        ->statePath('features'),
                    Section::make('User Features')
                        ->description('Features for User (Visitor).')
                        ->schema([
                            // Toggle::make('favorites')
                            //     ->disabled(),
                            // Toggle::make('login')
                            //     ->disabled(),
                            // Toggle::make('reviews')
                            //     ->disabled(),
                        ])
                        ->statePath('user_features'),
                ])
                ->columnSpan(['lg' => 1]),
        ];
    }
}
