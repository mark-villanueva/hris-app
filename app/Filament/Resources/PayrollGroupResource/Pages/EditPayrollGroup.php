<?php

namespace App\Filament\Resources\PayrollGroupResource\Pages;

use App\Filament\Resources\PayrollGroupResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPayrollGroup extends EditRecord
{
    protected static string $resource = PayrollGroupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
