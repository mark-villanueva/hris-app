<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PayrollGroupResource\Pages;
use App\Filament\Resources\PayrollGroupResource\RelationManagers;
use App\Models\PayrollGroup;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Section;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PayrollGroupResource extends Resource
{
    protected static ?string $model = PayrollGroup::class;

    protected static ?int $navigationSort = 1;
    protected static ?string $navigationGroup = 'Payroll Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
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
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('payroll_group_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('days_per_year')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('number_of_hours')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('period')
                    ->searchable(),
                Tables\Columns\IconColumn::make('default')
                    ->boolean(),
                Tables\Columns\TextColumn::make('first_timesheet_cutoff')
                    ->searchable(),
                Tables\Columns\TextColumn::make('first_paydate')
                    ->searchable(),
                Tables\Columns\TextColumn::make('second_timesheet_cutoff')
                    ->searchable(),
                Tables\Columns\TextColumn::make('second_paydate')
                    ->searchable(),
                Tables\Columns\TextColumn::make('paydate_on_non_workingday')
                    ->searchable(),
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
            'index' => Pages\ListPayrollGroups::route('/'),
            'create' => Pages\CreatePayrollGroup::route('/create'),
            'edit' => Pages\EditPayrollGroup::route('/{record}/edit'),
        ];
    }

   
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);

        return parent::getEloquentQuery()->withoutTrashed();
    }
}
