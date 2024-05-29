<?php

namespace App\Filament\Resources\PayrollResource\Pages;

use App\Filament\Resources\PayrollResource;
use Filament\Resources\Pages\Page;
use App\Models\User;
use App\Models\Employee;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Contracts\HasTable;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;
use Illuminate\Support\Facades\Route;
use App\Filament\Widgets\EmployeeOverview;

class ViewPayslip extends Page implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    protected static string $resource = PayrollResource::class;
    protected static string $view = 'filament.resources.payroll-resource.pages.view-payslip';

    public static function table(Table $table): Table
    {
        // Get the user ID from the route parameters
        $userId = Route::current()->parameter('record');

        $userPresentDays = EmployeeOverview::getUserPresentDays();
        $totalRegularHours = EmployeeOverview::getTotalRegularHours();
        $totalOvertimeHours = EmployeeOverview::getTotalOvertimeHours();

        return $table
            ->query(function () use ($userId) {
                return User::query()
                    ->join('employees', 'users.id', '=', 'employees.user_id')
                    ->select('users.*', 'employees.*')
                    ->where('users.id', $userId);
            })
            ->columns([
                TextColumn::make('name')
                    ->label('Employee')
                    ->sortable(),
                TextColumn::make('days_present')
                    ->label('Days Present')
                    ->sortable()
                    ->getStateUsing(function (User $record) use ($userPresentDays) {
                        return $userPresentDays[$record->id] ?? 0;
                    }),
                TextColumn::make('total_regular_hours')
                    ->label('Regular Hours')
                    ->sortable()
                    ->getStateUsing(function (User $record) use ($totalRegularHours) {
                        return $totalRegularHours[$record->id] ?? 0;
                    }),
                TextColumn::make('total_overtime_hours')
                    ->label('OT Hours')
                    ->sortable()
                    ->getStateUsing(function (User $record) use ($totalOvertimeHours) {
                        return $totalOvertimeHours[$record->id] ?? 0;
                    }),
                TextColumn::make('gross_pay')
                    ->label('Gross Pay')
                    ->getStateUsing(function (User $record) use ($totalRegularHours, $totalOvertimeHours) {
                        $userId = $record->id;
                        $regularHours = $totalRegularHours[$userId] ?? 0;
                        $overtimeHours = $totalOvertimeHours[$userId] ?? 0;

                        return self::calculateGrossPay($userId, $regularHours, $overtimeHours);
                    }),
                TextColumn::make('deductions')
                    ->label('Deductions')
                    ->sortable()
                    ->getStateUsing(function (User $record) {
                        return self::calculateDeductions($record->id);
                    }),
                TextColumn::make('allowance')
                    ->label('Allowance')
                    ->sortable()
                    ->getStateUsing(function (User $record) {
                        $employee = Employee::where('user_id', $record->id)->with('salary')->first();
                        return $employee->salary->nta ?? 0;
                    }),
                TextColumn::make('net_pay')
                    ->label('Net Pay')
                    ->sortable()
                    ->getStateUsing(function (User $record) use ($totalRegularHours, $totalOvertimeHours) {
                        $userId = $record->id;
                        $regularHours = $totalRegularHours[$userId] ?? 0;
                        $overtimeHours = $totalOvertimeHours[$userId] ?? 0;
                        $grossPay = self::calculateGrossPay($userId, $regularHours, $overtimeHours);
                        $deductions = self::calculateDeductions($userId);
                        $employee = Employee::where('user_id', $userId)->with('salary')->first();
                        $nta = $employee->salary->nta ?? 0;

                        return $grossPay - $deductions + $nta;
                    }),
            ])
            ->filters([
                // Filters here
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
            ]);
    }

    public static function calculateGrossPay($userId, $regularHours, $overtimeHours): float
    {
        $employee = Employee::where('user_id', $userId)->first();
        $hourlyRate = $employee->salary->hourly_rate;
        $otRate = $employee->salary->ot_rate;

        $regularPay = $regularHours * $hourlyRate;
        $overtimePay = $overtimeHours * $otRate;

        return $regularPay + $overtimePay;
    }

    public static function calculateDeductions($userId): float
    {
        $employee = Employee::where('user_id', $userId)->first();
        $bir = $employee->salary->bir;
        $sss = $employee->salary->sss;
        $philhealth = $employee->salary->philhealth;
        $pagibig = $employee->salary->pagibig;

        return $bir + $sss + $philhealth + $pagibig;
    }
}
