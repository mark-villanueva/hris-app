<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PayrollResource\Pages;
use App\Models\Payroll;
use App\Models\User;
use App\Filament\Widgets\EmployeeOverview;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PayrollResource extends Resource
{
    protected static ?string $model = Payroll::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';
    protected static ?int $navigationSort = 5;
    protected static ?string $title = 'Payroll';
    protected static ?string $navigationLabel = 'Payroll';
    protected ?string $heading = 'Payroll';
    protected static ?string $navigationGroup = 'Admin Panel';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        $userPresentDays = EmployeeOverview::getUserPresentDays();
        $totalRegularHours = EmployeeOverview::getTotalRegularHours();
        $totalOvertimeHours = EmployeeOverview::getTotalOvertimeHours();

        return $table
            ->query(User::query())
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Employee')
                    ->sortable(),
                Tables\Columns\TextColumn::make('days_present')
                    ->label('Days Present')
                    ->sortable()
                    ->getStateUsing(function (User $record) use ($userPresentDays) {
                        return $userPresentDays[$record->id] ?? 0;
                    }),
                Tables\Columns\TextColumn::make('total_regular_hours')
                    ->label('Regular Hours')
                    ->sortable()
                    ->getStateUsing(function (User $record) use ($totalRegularHours) {
                        return $totalRegularHours[$record->id] ?? 0;
                    }),
                Tables\Columns\TextColumn::make('total_overtime_hours')
                    ->label('OT Hours')
                    ->sortable()
                    ->getStateUsing(function (User $record) use ($totalOvertimeHours) {
                        return $totalOvertimeHours[$record->id] ?? 0;
                    }),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPayrolls::route('/'),
            'create' => Pages\CreatePayroll::route('/create'),
            'edit' => Pages\EditPayroll::route('/{record}/edit'),
        ];
    }
}
