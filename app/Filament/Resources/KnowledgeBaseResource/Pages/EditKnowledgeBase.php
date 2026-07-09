<?php

namespace App\Filament\Resources\KnowledgeBaseResource\Pages;

use App\Filament\Resources\KnowledgeBaseResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditKnowledgeBase extends EditRecord
{
    protected static string $resource = KnowledgeBaseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function afterSave(): void
    {
        // Ekstrak ulang teks hanya bila file PDF diganti (agar suntingan manual tidak tertimpa).
        if ($this->record->wasChanged('file_path')) {
            KnowledgeBaseResource::extractAndStoreContent($this->record);
        }
    }
}
