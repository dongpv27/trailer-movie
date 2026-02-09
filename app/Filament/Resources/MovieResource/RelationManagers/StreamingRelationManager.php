<?php

namespace App\Filament\Resources\MovieResource\RelationManagers;

use Filament\Actions;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Schemas\Schema;

class StreamingRelationManager extends RelationManager
{
    protected static string $relationship = 'streamings';

    protected static ?string $title = 'Nền tảng chiếu';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Forms\Components\Select::make('status')
                    ->label('Trạng thái')
                    ->options([
                        'available' => 'Đang có',
                        'coming_soon' => 'Sắp chiếu',
                    ])
                    ->default('available')
                    ->required(),
                Forms\Components\DateTimePicker::make('available_date')
                    ->label('Ngày có')
                    ->default(now()),
                Forms\Components\TextInput::make('external_url')
                    ->label('Link đến phim trên rạp/nền tảng')
                    ->url()
                    ->helperText('Để trống sẽ tự động tạo link tìm kiếm theo tên phim'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nền tảng'),
                Tables\Columns\TextColumn::make('type')
                    ->label('Loại')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'cinema' => 'warning',
                        'streaming' => 'info',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'cinema' => 'Rạp chiếu',
                        'streaming' => 'Streaming',
                        default => $state,
                    }),
                Tables\Columns\TextColumn::make('pivot.status')
                    ->label('Trạng thái')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'available' => 'success',
                        'coming_soon' => 'warning',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'available' => 'Đang có',
                        'coming_soon' => 'Sắp chiếu',
                        default => $state,
                    }),
                Tables\Columns\TextColumn::make('pivot.available_date')
                    ->label('Ngày có')
                    ->dateTime()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('pivot.external_url')
                    ->label('Link phim')
                    ->url(fn ($record) => $record->pivot->external_url)
                    ->openUrlInNewTab()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Actions\CreateAction::make('attach_streaming')
                    ->label('Thêm nền tảng')
                    ->form([
                        Forms\Components\Select::make('streaming_id')
                            ->label('Nền tảng')
                            ->options(fn () => \App\Models\Streaming::where('is_active', true)->orderBy('sort_order')->pluck('name', 'id'))
                            ->required()
                            ->searchable()
                            ->preload()
                            ->live(),
                        Forms\Components\Select::make('status')
                            ->label('Trạng thái')
                            ->options([
                                'available' => 'Đang có',
                                'coming_soon' => 'Sắp chiếu',
                            ])
                            ->default('available')
                            ->required(),
                        Forms\Components\DateTimePicker::make('available_date')
                            ->label('Ngày có')
                            ->default(now()),
                        Forms\Components\TextInput::make('external_url')
                            ->label('Link đến phim trên rạp/nền tảng')
                            ->url()
                            ->helperText('Để trống sẽ tự động tạo link tìm kiếm'),
                    ])
                    ->action(function (array $data) {
                        $this->getOwnerRecord()->streamings()->attach($data['streaming_id'], [
                            'status' => $data['status'],
                            'available_date' => $data['available_date'],
                            'external_url' => $data['external_url'] ?? null,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    })
                    ->after(function () {
                        // Refresh the relation manager table
                        $this->dispatch('refreshRelationManager');
                    })
                    ->successNotificationTitle('Đã thêm nền tảng chiếu thành công'),
            ])
            ->actions([
                Actions\EditAction::make()
                    ->successNotificationTitle('Đã cập nhật thông tin nền tảng'),
                Actions\DetachAction::make()
                    ->successNotificationTitle('Đã xóa nền tảng chiếu'),
            ])
            ->bulkActions([
                Actions\BulkActionGroup::make([
                    Actions\DetachBulkAction::make()
                        ->successNotificationTitle('Đã xóa các nền tảng đã chọn'),
                ]),
            ]);
    }
}
