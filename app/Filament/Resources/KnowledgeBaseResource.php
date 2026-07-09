<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KnowledgeBaseResource\Pages;
use App\Models\KnowledgeBase;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Smalot\PdfParser\Parser;

class KnowledgeBaseResource extends Resource
{
    protected static ?string $model = KnowledgeBase::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationGroup = 'Settings';

    protected static ?string $navigationLabel = 'Knowledge Base (RPJMD)';

    protected static ?string $modelLabel = 'Knowledge Base';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->label('Judul Dokumen')
                    ->placeholder('mis. RPJMD Kabupaten Pasuruan 2025-2029')
                    ->maxLength(255),

                Forms\Components\FileUpload::make('file_path')
                    ->label('Dokumen PDF RPJMD')
                    ->helperText('Unggah file PDF. Teks akan diekstrak otomatis dan dijadikan pengetahuan chatbot setelah disimpan.')
                    ->acceptedFileTypes(['application/pdf'])
                    ->maxSize(51200) // 50 MB (samakan dengan batas Livewire di config/livewire.php)
                    ->disk('local')
                    ->directory('knowledge-base')
                    ->downloadable()
                    ->required()
                    ->columnSpanFull(),

                Forms\Components\Toggle::make('is_active')
                    ->label('Aktif (dipakai chatbot)')
                    ->default(true),

                Forms\Components\Textarea::make('content')
                    ->label('Teks Terekstrak (otomatis)')
                    ->helperText('Terisi otomatis dari PDF setelah disimpan. Boleh disunting manual bila perlu.')
                    ->rows(10)
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Judul')
                    ->searchable()
                    ->wrap(),
                Tables\Columns\TextColumn::make('content')
                    ->label('Panjang Teks')
                    ->formatStateUsing(fn (?string $state) => number_format(strlen((string) $state)) . ' karakter')
                    ->badge(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Diperbarui')
                    ->dateTime()
                    ->sortable(),
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
            'index' => Pages\ListKnowledgeBases::route('/'),
            'create' => Pages\CreateKnowledgeBase::route('/create'),
            'edit' => Pages\EditKnowledgeBase::route('/{record}/edit'),
        ];
    }

    /**
     * Ekstrak teks dari PDF yang tersimpan lalu simpan ke kolom `content`.
     * Dipanggil dari hook afterCreate / afterSave pada halaman resource.
     */
    public static function extractAndStoreContent(KnowledgeBase $record): void
    {
        if (empty($record->file_path)) {
            return;
        }

        try {
            $absolutePath = Storage::disk('local')->path($record->file_path);

            if (!is_file($absolutePath)) {
                Log::warning('KnowledgeBase PDF tidak ditemukan: ' . $absolutePath);
                return;
            }

            $parser = new Parser();
            $pdf = $parser->parseFile($absolutePath);
            $text = $pdf->getText();

            // Rapikan whitespace berlebih dari hasil ekstraksi.
            $text = preg_replace('/[ \t]+/', ' ', $text);
            $text = preg_replace('/\n{3,}/', "\n\n", $text);
            $text = trim($text);

            // Simpan tanpa memicu ulang hook (updateQuietly), lalu bersihkan cache.
            $record->updateQuietly(['content' => $text]);
            \Illuminate\Support\Facades\Cache::forget('kb_pdf_active_content');
        } catch (\Throwable $e) {
            Log::error('Gagal ekstrak teks PDF KnowledgeBase #' . $record->id . ': ' . $e->getMessage());
        }
    }
}
