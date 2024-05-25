<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LeaveRequestResource\Pages;
use App\Filament\Resources\LeaveRequestResource\RelationManagers;
use App\Models\LeaveRequest;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LeaveRequestResource extends Resource
{
    protected static ?string $model = LeaveRequest::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    public static function form(Form $form): Form
    {
        $user = Auth::user(); // Get the authenticated user here
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->label('Employee name')
                    ->relationship('user', 'name')
                    ->options(
                        function () use ($user) {
                            // Return an array containing only the authenticated user
                            return [$user->getKey() => $user->name];
                        }
                    )
                  
                    ->default($user->getKey()) // Set the default value to the authenticated user's ID
                    ->required(),                  
                Forms\Components\Select::make('type')
                    ->required()
                    ->options([
                        'Sick Leave' => 'Sick Leave',
                        'Maternity Leave' => 'Maternity Leave',
                        'Vacation Leave' => 'Vacation Leave',
                        'Birthday Leave' => 'Birthday Leave',
                    ])
                    ->native(false),
                Forms\Components\DatePicker::make('start_date')
                    ->required(),
                Forms\Components\DatePicker::make('end_date')
                    ->required(),
                Forms\Components\TextInput::make('status')
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        $query = LeaveRequest::query();

        // If the user ID is 1, show all leave requests
        if (Auth::id() == 1) {
            $query->withoutGlobalScope(SoftDeletingScope::class);
        } else {
            // Otherwise, show leave requests for the authenticated user
            $query->where('user_id', Auth::id());
        }

        return $table
            ->query($query)
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('start_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('end_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->searchable(),
              
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
            'index' => Pages\ListLeaveRequests::route('/'),
            'create' => Pages\CreateLeaveRequest::route('/create'),
            'edit' => Pages\EditLeaveRequest::route('/{record}/edit'),
        ];
    }
}
