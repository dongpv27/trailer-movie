<?php

namespace App\Filament\Resources\Streamings\Pages;

use App\Filament\Resources\Streamings\StreamingResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditStreaming extends EditRecord
{
    protected static string $resource = StreamingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
