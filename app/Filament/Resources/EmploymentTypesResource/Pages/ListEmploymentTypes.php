<?php

namespace App\Filament\Resources\EmploymentTypesResource\Pages;

use App\Filament\Resources\EmploymentTypesResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEmploymentTypes extends ListRecords
{
    protected static string $resource = EmploymentTypesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
