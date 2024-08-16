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

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?int $navigationSort = 5;
    protected static ?string $navigationGroup = 'Company Settings';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Government')
                ->schema([
                Forms\Components\TextInput::make('employee_number')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('last_name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('first_name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('middle_name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('office_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('department_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('position')
                    ->maxLength(255),
                Forms\Components\Select::make('employment_types_id')
                    ->label('Employment Type')
                    ->relationship('employmenttypes', 'employment_type')
                    ->preload()
                    ->searchable()
                    ->required(),
                Forms\Components\DatePicker::make('date_hired'),
                Forms\Components\TextInput::make('biometric_id')
                    ->maxLength(255),
                ])
                ->columns(2),

                Section::make('Payroll')
                ->schema([
                Forms\Components\Select::make('payment_type')
                    ->options([
                        'monthly paid' => 'Monthly Paid',
                        'daily paid' => 'Daily Paid',
                    ]),
                Forms\Components\TextInput::make('monthly_basic_salary')
                    ->prefix('Php')
                    ->maxLength(255),
                Forms\Components\Checkbox::make('monday_to_friday')
                    ->required(),
                Forms\Components\Checkbox::make('minimum_wage')
                    ->required(),
                Forms\Components\TextInput::make('payroll_group_id')
                    ->required()
                    ->numeric(),
                ])
                ->columns(2),

                Section::make('Government')
                ->schema([
                Forms\Components\TextInput::make('tin')
                    ->maxLength(255),
                Forms\Components\TextInput::make('sss')
                    ->maxLength(255),
                Forms\Components\TextInput::make('philhealth')
                    ->maxLength(255),
                Forms\Components\TextInput::make('hdmf')
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
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
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
