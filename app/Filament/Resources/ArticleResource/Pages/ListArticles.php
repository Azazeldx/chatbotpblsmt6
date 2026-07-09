<?php

namespace App\Filament\Resources\ArticleResource\Pages;

use App\Filament\Resources\ArticleResource;
use App\Models\Category;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;

class ListArticles extends ListRecords
{
    protected static string $resource = ArticleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    /**
     * Kategori yang tidak ditampilkan sebagai tab di daftar artikel (berdasarkan slug).
     */
    protected array $hiddenTabCategories = ['event', 'departemen'];

    public function getTabs(): array
    {
        $categories = Category::whereNotIn('slug', $this->hiddenTabCategories)->get();
        $tabs = [];

        $tabs[] = Tab::make('All');

        foreach ($categories as $category) {
            $tabs[] = Tab::make($category->category_name)
                ->modifyQueryUsing(function ($query) use ($category) {
                    return $query->where('category_id', $category->id);
                });
        }

        return $tabs;
    }
}
