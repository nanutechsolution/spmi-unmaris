<?php

namespace App\Filament\Resources\Edom\Questions\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class QuestionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('category')
                    ->label('Kategori Kompetensi')
                    ->options([
                        'Pedagogik' => 'Kompetensi Pedagogik',
                        'Profesional' => 'Kompetensi Profesional',
                        'Kepribadian' => 'Kompetensi Kepribadian',
                        'Sosial' => 'Kompetensi Sosial',
                    ])
                    ->required(),
                TextInput::make('order_column')
                    ->label('Urutan Tampil')
                    ->numeric()
                    ->default(0),
                Textarea::make('question_text')
                    ->label('Isi Pertanyaan')
                    ->required()
                    ->columnSpanFull(),
                Toggle::make('is_active')
                    ->label('Status Aktif')
                    ->default(true),
            ]);
    }
}
