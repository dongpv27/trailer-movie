<?php

namespace App\Filament\Resources\Streamings\Schemas;

use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Schemas\Schema;

class StreamingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),
                        Select::make('type')
                            ->required()
                            ->options([
                                'cinema' => 'Rạp chiếu phim',
                                'streaming' => 'Streaming',
                            ])
                            ->default('streaming'),
                        TextInput::make('icon')
                            ->helperText('Tên Heroicon hoặc SVG icon')
                            ->maxLength(255),
                        TextInput::make('url')
                            ->url()
                            ->helperText('Link external đến nền tảng')
                            ->maxLength(255),
                        Toggle::make('is_active')
                            ->label('Active')
                            ->default(true),
                        TextInput::make('sort_order')
                            ->numeric()
                            ->default(0),
                    ])
                    ->columns(2),
            ]);
    }
}
