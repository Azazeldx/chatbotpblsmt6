<?php

namespace App\Filament\Resources\KnowledgeBaseResource\Pages;

use App\Filament\Resources\KnowledgeBaseResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateKnowledgeBase extends CreateRecord
{
    protected static string $resource = KnowledgeBaseResource::class;

    protected function afterCreate(): void
    {
        // Ekstrak teks dari PDF yang baru diunggah.
        KnowledgeBaseResource::extractAndStoreContent($this->record);
    }
}
