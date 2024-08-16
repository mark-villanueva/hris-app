<?php

namespace App\Filament\Resources\EmploymentTypesResource\Pages;

use App\Filament\Resources\EmploymentTypesResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEmploymentTypes extends EditRecord
{
    protected static string $resource = EmploymentTypesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
