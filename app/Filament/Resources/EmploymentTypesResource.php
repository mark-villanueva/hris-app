<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EmploymentTypesResource\Pages;
use App\Filament\Resources\EmploymentTypesResource\RelationManagers;
use App\Models\EmploymentTypes;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\IconColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EmploymentTypesResource extends Resource
{
    protected static ?string $model = EmploymentTypes::class;

    protected static ?int $navigationSort = 4;
    protected static ?string $navigationGroup = 'Company Settings';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('employment_type')
                    ->required()
                    ->placeholder('Type employment type')
                    ->maxLength(255),
                Forms\Components\Checkbox::make('payroll')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('employment_type')
                    ->searchable(),
                IconColumn::make('payroll')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-badge')
                    ->falseIcon('heroicon-o-x-mark')
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
            'index' => Pages\ListEmploymentTypes::route('/'),
            'create' => Pages\CreateEmploymentTypes::route('/create'),
            'edit' => Pages\EditEmploymentTypes::route('/{record}/edit'),
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
