<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RateResource\Pages;
use App\Filament\Resources\RateResource\RelationManagers;
use App\Models\Rate;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RateResource extends Resource
{
    protected static ?string $model = Rate::class;

    protected static ?int $navigationSort = 3;
    protected static ?string $navigationGroup = 'Time & Attendance';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('rates_for')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('regular')
                    ->placeholder('0.000')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('overtime')
                    ->placeholder('0.000')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('night_differential_rate')
                    ->placeholder('0.000')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('night_differential_ot_rate')
                    ->placeholder('0.000')
                    ->required()
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('rates_for')
                    ->searchable(),
                Tables\Columns\TextColumn::make('regular')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('overtime')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('night_differential_rate')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('night_differential_ot_rate')
                    ->numeric()
                    ->sortable(),
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
            'index' => Pages\ListRates::route('/'),
            'create' => Pages\CreateRate::route('/create'),
            'edit' => Pages\EditRate::route('/{record}/edit'),
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
