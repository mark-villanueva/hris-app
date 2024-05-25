<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Models\Schedule;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class Attendance extends Page implements HasForms, HasTable
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.attendance';

    use InteractsWithTable;
    use InteractsWithForms;
    
    public function table(Table $table): Table
    {
        return $table
            ->query(Schedule::where('user_id', Auth::id()))
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Employee')
                    ->sortable(),
                Tables\Columns\TextColumn::make('start_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('end_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('start_shift')
                    ->sortable(),
                Tables\Columns\TextColumn::make('end_shift')
                    ->sortable(),
                Tables\Columns\TextColumn::make('time_in')
                    ->label('Time In')
                    ->sortable(),
                Tables\Columns\TextColumn::make('time_out')
                    ->label('Time Out')
                    ->sortable(),
            ])
            ->filters([
                // ...
            ])
            ->actions([
                Tables\Actions\Action::make('time_in')
                    ->label('Time In')
                    ->action(function ($record) {
                        $record->update(['time_in' => Carbon::now()]);
                    })
                    ->hidden(fn ($record) => $record->time_in !== null), // Hide if already clocked in
                Tables\Actions\Action::make('time_out')
                    ->label('Time Out')
                    ->action(function ($record) {
                        $record->update(['time_out' => Carbon::now()]);
                    })
                    ->hidden(fn ($record) => $record->time_in === null || $record->time_out !== null), // Hide if not clocked in or already clocked out
            ])
            ->bulkActions([
                // ...
            ]);
    }
}
