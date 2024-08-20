<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EmployeeResource\Pages;
use App\Filament\Resources\EmployeeResource\RelationManagers;
use App\Models\Employee;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Section;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EmployeeResource extends Resource
{
    protected static ?string $model = Employee::class;

    protected static ?int $navigationSort = 5;
    protected static ?string $navigationGroup = 'Company Settings';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Government')
                ->schema([
                Forms\Components\TextInput::make('employee_number')
                    ->disabled() 
                    ->default(Employee::generateEmployeeNumber())
                    ->maxLength(255),
                Forms\Components\TextInput::make('last_name')
                    ->placeholder('Type last name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('first_name')
                    ->placeholder('Type first name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('middle_name')
                    ->placeholder('Type middle name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('office_id')
                    ->helperText('Click + button on the right to add Office')
                    ->label('Office')
                    ->relationship('office', 'office_name')
                    ->preload()
                    ->searchable()
                    ->required()
                    ->createOptionForm([
                        Forms\Components\TextInput::make('office_name')
                            ->placeholder('Type office name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('office_address')
                            ->placeholder('Type office address')
                            ->required()
                            ->maxLength(255),
                    ]),
                Forms\Components\Select::make('department_id')
                    ->helperText('Click + button on the right to add Department')
                    ->label('Department')
                    ->relationship('department', 'department_name')
                    ->preload()
                    ->searchable()
                    ->required()
                    ->createOptionForm([
                        Forms\Components\TextInput::make('department_name')
                        ->placeholder('Type department name')
                        ->required(),
                    ]),
                Forms\Components\TextInput::make('position')
                    ->placeholder('Type position')
                    ->maxLength(255),
                Forms\Components\Select::make('employment_types_id')
                    ->label('Employment Type')
                    ->relationship('employmenttypes', 'employment_type')
                    ->preload()
                    ->searchable()
                    ->required(),
                Forms\Components\DatePicker::make('date_hired'),
                Forms\Components\TextInput::make('biometric_id')
                    ->placeholder('Type biometric id')
                    ->helperText('The ID used in biometric machine if any')
                    ->label('Biometric ID')
                    ->maxLength(255),
                ])
                ->columns(2),

                Section::make('Payroll')
                ->schema([
                Forms\Components\Select::make('payment_type')
                    ->required()
                    ->options([
                        'monthly paid' => 'Monthly Paid',
                        'daily paid' => 'Daily Paid',
                    ]),
                Forms\Components\TextInput::make('monthly_basic_salary')
                    ->placeholder('0')
                    ->prefix('Php')
                    ->maxLength(255),
                Forms\Components\Checkbox::make('monday_to_friday')
                    ->label('Monday to Friday only?')
                    ->helperText('Check if Monday to Friday. Uncheck if weekends are included.')
                    ->required(),
                Forms\Components\Checkbox::make('minimum_wage')
                    ->required(),
                Forms\Components\Select::make('payroll_group')
                    ->label('Payroll Group')
                    ->helperText('Click + button on the right to add Payroll Group')
                    ->relationship('payrollgroup', 'payroll_group_name')
                    ->preload()
                    ->searchable()
                    ->required()
                    ->createOptionForm([
                        Section::make('')
                            ->schema([
                            Forms\Components\TextInput::make('payroll_group_name')
                                ->placeholder('Type payroll group name')
                                ->required()
                                ->maxLength(255),
                            Forms\Components\TextInput::make('days_per_year')
                                ->placeholder('0')
                                ->helperText('Number of days per year. Mon-Fri is 261. Mon-Sat is 313')
                                ->numeric(),
                            Forms\Components\TextInput::make('number_of_hours')
                                ->placeholder('0')
                                ->helperText('The required number of hours per day')
                                ->numeric(),
                            Forms\Components\Select::make('period')
                                ->required()
                                ->options([
                                    'monthly' => 'Monthly',
                                    'semi-monthly' => 'Semi-Monthly',
                                ]),
                            Forms\Components\Checkbox::make('default')
                                ->label('Set as default'),
                            ])
                            ->columns(2),
            
                            Section::make('Cut-off')
                            ->schema([
                            Forms\Components\Select::make('first_timesheet_cutoff')
                                ->label('First Timesheet Cut-off')
                                ->required()
                                ->options([
                                'day 1' => 'Day 1', 'day 2' => 'Day 2', 'day 3' => 'Day 3',
                                'day 4' => 'Day 4', 'day 5' => 'Day 5', 'day 6' => 'Day 6',
                                'day 7' => 'Day 7', 'day 8' => 'Day 8', 'day 9' => 'Day 9',
                                'day 10' => 'Day 10', 'day 11' => 'Day 11', 'day 12' => 'Day 12',
                                'day 13' => 'Day 13', 'day 14' => 'Day 14', 'day 15' => 'Day 15',
                                'day 16' => 'Day 16', 'day 17' => 'Day 17', 'day 18' => 'Day 18',
                                'day 19' => 'Day 19', 'day 20' => 'Day 20', 'day 21' => 'Day 21',
                                'day 22' => 'Day 22', 'day 23' => 'Day 23', 'day 24' => 'Day 24',
                                'day 25' => 'Day 25', 'day 26' => 'Day 26','day 27' => 'Day 27',
                                'day 28' => 'Day 28', 'day 29' => 'Day 29', 'day 30' => 'Day 30',
                                'day 31' => 'Day 31'
                                ]),
                            Forms\Components\Select::make('first_paydate')
                                ->label('First Pay date')
                                ->required()
                                ->options([
                                    'day 1' => 'Day 1', 'day 2' => 'Day 2', 'day 3' => 'Day 3',
                                    'day 4' => 'Day 4', 'day 5' => 'Day 5', 'day 6' => 'Day 6',
                                    'day 7' => 'Day 7', 'day 8' => 'Day 8', 'day 9' => 'Day 9',
                                    'day 10' => 'Day 10', 'day 11' => 'Day 11', 'day 12' => 'Day 12',
                                    'day 13' => 'Day 13', 'day 14' => 'Day 14', 'day 15' => 'Day 15',
                                    'day 16' => 'Day 16', 'day 17' => 'Day 17', 'day 18' => 'Day 18',
                                    'day 19' => 'Day 19', 'day 20' => 'Day 20', 'day 21' => 'Day 21',
                                    'day 22' => 'Day 22', 'day 23' => 'Day 23', 'day 24' => 'Day 24',
                                    'day 25' => 'Day 25', 'day 26' => 'Day 26','day 27' => 'Day 27',
                                    'day 28' => 'Day 28', 'day 29' => 'Day 29', 'day 30' => 'Day 30',
                                    'day 31' => 'Day 31'
                                ]),
                            Forms\Components\Select::make('second_timesheet_cutoff')
                                ->label('Second Timesheet Cut-off')
                                ->required()
                                ->options([
                                    'day 1' => 'Day 1', 'day 2' => 'Day 2', 'day 3' => 'Day 3',
                                    'day 4' => 'Day 4', 'day 5' => 'Day 5', 'day 6' => 'Day 6',
                                    'day 7' => 'Day 7', 'day 8' => 'Day 8', 'day 9' => 'Day 9',
                                    'day 10' => 'Day 10', 'day 11' => 'Day 11', 'day 12' => 'Day 12',
                                    'day 13' => 'Day 13', 'day 14' => 'Day 14', 'day 15' => 'Day 15',
                                    'day 16' => 'Day 16', 'day 17' => 'Day 17', 'day 18' => 'Day 18',
                                    'day 19' => 'Day 19', 'day 20' => 'Day 20', 'day 21' => 'Day 21',
                                    'day 22' => 'Day 22', 'day 23' => 'Day 23', 'day 24' => 'Day 24',
                                    'day 25' => 'Day 25', 'day 26' => 'Day 26','day 27' => 'Day 27',
                                    'day 28' => 'Day 28', 'day 29' => 'Day 29', 'day 30' => 'Day 30',
                                    'day 31' => 'Day 31'
                                ]),
                            Forms\Components\Select::make('second_paydate')
                                ->label('Second Pay date')
                                ->required()
                                ->options([
                                    'day 1' => 'Day 1', 'day 2' => 'Day 2', 'day 3' => 'Day 3',
                                    'day 4' => 'Day 4', 'day 5' => 'Day 5', 'day 6' => 'Day 6',
                                    'day 7' => 'Day 7', 'day 8' => 'Day 8', 'day 9' => 'Day 9',
                                    'day 10' => 'Day 10', 'day 11' => 'Day 11', 'day 12' => 'Day 12',
                                    'day 13' => 'Day 13', 'day 14' => 'Day 14', 'day 15' => 'Day 15',
                                    'day 16' => 'Day 16', 'day 17' => 'Day 17', 'day 18' => 'Day 18',
                                    'day 19' => 'Day 19', 'day 20' => 'Day 20', 'day 21' => 'Day 21',
                                    'day 22' => 'Day 22', 'day 23' => 'Day 23', 'day 24' => 'Day 24',
                                    'day 25' => 'Day 25', 'day 26' => 'Day 26','day 27' => 'Day 27',
                                    'day 28' => 'Day 28', 'day 29' => 'Day 29', 'day 30' => 'Day 30',
                                    'day 31' => 'Day 31'
                                ]),
                            Forms\Components\Select::make('paydate_on_non_workingday')
                            ->label('Pay Date on non-working day?')
                            ->required()
                            ->options([
                                'pay date after non-working day' => 'Pay date after non-working day', 
                                'pay date before non-working day' => 'Pay date before non-working day', 
                                'remain as schedule pay date' => 'Remain as schedule pay date', 
                            ])
                            ])
                            ->columns(2),
                    ]),
                ])
                ->columns(2),

                Section::make('Government')
                ->schema([
                Forms\Components\TextInput::make('tin')
                    ->placeholder('000-000-000-000')
                    ->label('TIN')
                    ->maxLength(255),
                Forms\Components\TextInput::make('sss')
                    ->placeholder('00-0000000-0')
                    ->label('SSS')
                    ->maxLength(255),
                Forms\Components\TextInput::make('philhealth')
                    ->placeholder('00-000000000-0')
                    ->label('PhilHealth')
                    ->maxLength(255),
                Forms\Components\TextInput::make('hdmf')
                    ->placeholder('0000-0000-0000')
                    ->label('HDMF')
                    ->maxLength(255),
                ])
                ->columns(2),

                Section::make('Benefits')
                ->schema([
                Forms\Components\Checkbox::make('timesheet_required'),
                Forms\Components\Checkbox::make('regular_holiday_pay'),
                Forms\Components\Checkbox::make('special_holiday_pay'),
                Forms\Components\Checkbox::make('premium_holiday_pay'),
                Forms\Components\Checkbox::make('regular_special_holiday_pay'),
                Forms\Components\Checkbox::make('restday_pay'),
                Forms\Components\Checkbox::make('overtime_pay'),
                Forms\Components\Checkbox::make('de_minimis'),
                Forms\Components\Checkbox::make('night_differential'),
                ])
                ->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('employee_number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('last_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('first_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('middle_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('office_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('department_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('position')
                    ->searchable(),
                Tables\Columns\TextColumn::make('employment_types_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('date_hired')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('biometric_id')
                    ->searchable(),
                Tables\Columns\TextColumn::make('payment_type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('monthly_basic_salary')
                    ->searchable(),
                Tables\Columns\IconColumn::make('monday_to_friday')
                    ->boolean(),
                Tables\Columns\IconColumn::make('minimum_wage')
                    ->boolean(),
                Tables\Columns\TextColumn::make('payroll_group_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tin')
                    ->searchable(),
                Tables\Columns\TextColumn::make('sss')
                    ->searchable(),
                Tables\Columns\TextColumn::make('philhealth')
                    ->searchable(),
                Tables\Columns\TextColumn::make('hdmf')
                    ->searchable(),
                Tables\Columns\TextColumn::make('timesheet_required')
                    ->searchable(),
                Tables\Columns\TextColumn::make('regular_holiday_pay')
                    ->searchable(),
                Tables\Columns\TextColumn::make('special_holiday_pay')
                    ->searchable(),
                Tables\Columns\TextColumn::make('premium_holiday_pay')
                    ->searchable(),
                Tables\Columns\TextColumn::make('regular_special_holiday_pay')
                    ->searchable(),
                Tables\Columns\TextColumn::make('restday_pay')
                    ->searchable(),
                Tables\Columns\TextColumn::make('overtime_pay')
                    ->searchable(),
                Tables\Columns\TextColumn::make('de_minimis')
                    ->searchable(),
                Tables\Columns\TextColumn::make('night_differential')
                    ->searchable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('office')
                ->relationship('office', 'office_name')
                ->searchable()
                ->preload(),
                Tables\Filters\SelectFilter::make('department')
                ->relationship('department', 'department_name')
                ->searchable()
                ->preload(),
                Tables\Filters\SelectFilter::make('payroll_group')
                ->relationship('payrollgroup', 'payroll_group_name')
                ->searchable()
                ->preload(),
                Tables\Filters\SelectFilter::make('employment_type')
                ->relationship('employmenttypes', 'employment_type')
                ->searchable()
                ->preload(),
                Tables\Filters\TrashedFilter::make(),
                
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
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
            'index' => Pages\ListEmployees::route('/'),
            'create' => Pages\CreateEmployee::route('/create'),
            'edit' => Pages\EditEmployee::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
