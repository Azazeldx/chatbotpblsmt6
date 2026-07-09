<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KnowledgeBaseResource\Pages;
use App\Models\KnowledgeBase;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Process;
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
     *
     * Alur: utamakan pdftotext -layout (poppler) yang menjaga penjajaran kolom
     * tabel; bila binary tidak tersedia di server, jatuh ke Smalot PdfParser.
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

            // 1) Coba pdftotext -layout; 2) fallback Smalot bila gagal/tak ada.
            $text = static::extractWithPdftotext($absolutePath)
                ?? static::extractWithSmalot($absolutePath);

            $text = static::tidyExtractedText($text);

            // Simpan tanpa memicu ulang hook (updateQuietly), lalu bersihkan cache.
            $record->updateQuietly(['content' => $text]);
            Cache::forget('kb_pdf_active_content');
        } catch (\Throwable $e) {
            Log::error('Gagal ekstrak teks PDF KnowledgeBase #' . $record->id . ': ' . $e->getMessage());
        }
    }

    /**
     * Ekstraksi utama memakai pdftotext -layout (poppler). Flag -layout menjaga
     * penjajaran kolom sehingga tabel tetap terbaca. Return null bila binary
     * tidak tersedia atau proses gagal, agar pemanggil bisa jatuh ke fallback.
     */
    private static function extractWithPdftotext(string $absolutePath): ?string
    {
        try {
            $result = Process::timeout(120)->run([
                'pdftotext', '-layout', '-enc', 'UTF-8', $absolutePath, '-',
            ]);
        } catch (\Throwable $e) {
            // Binary 'pdftotext' tidak ditemukan di server.
            Log::info('pdftotext tidak tersedia, memakai Smalot: ' . $e->getMessage());
            return null;
        }

        if (!$result->successful()) {
            Log::info('pdftotext gagal (exit ' . $result->exitCode() . '), memakai Smalot.');
            return null;
        }

        $output = $result->output();
        return trim($output) !== '' ? $output : null;
    }

    /**
     * Fallback: Smalot PdfParser (PHP murni, tanpa binary). Kualitas tabel
     * lebih rendah, tapi tidak butuh dependency sistem.
     */
    private static function extractWithSmalot(string $absolutePath): string
    {
        $parser = new Parser();
        $pdf = $parser->parseFile($absolutePath);

        return $pdf->getText();
    }

    /**
     * Rapikan hasil ekstraksi TANPA merusak penjajaran kolom dari -layout:
     * hanya buang spasi di ujung baris & mampatkan baris kosong berlebih.
     * (Sengaja tidak mengecilkan spasi di tengah baris — itulah yang menjaga tabel.)
     */
    private static function tidyExtractedText(string $text): string
    {
        $text = str_replace("\r\n", "\n", $text);
        $text = preg_replace('/[ \t]+\n/', "\n", $text);   // spasi/tab di akhir baris
        $text = preg_replace('/\n{3,}/', "\n\n", $text);    // baris kosong berlebih
        return trim($text);
    }
}
