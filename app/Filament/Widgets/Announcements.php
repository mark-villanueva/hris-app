<?php

namespace App\Filament\Widgets;

use App\Models\Announcement;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Tables\Columns\Layout\Panel;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Support\Enums\FontWeight;

class Announcements extends BaseWidget
{
    protected static ?int $sort = 2;
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(Announcement::query())
            ->columns([
                Stack::make([
                Tables\Columns\TextColumn::make('title')
                    ->weight(FontWeight::Bold),
                Panel::make([
                Tables\Columns\TextColumn::make('announcement'),
                ])->collapsible(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('By'),
                Tables\Columns\TextColumn::make('created_at')
                    ->date(),
                    // ->toggleable(isToggledHiddenByDefault: true),
                ]),
            ])
            ->contentGrid([
                'md' => 2,
                'xl' => 1,
            ])
            ->filters([
                //
            ]);
            // ->actions([
            //     // Tables\Actions\EditAction::make(),
            //     // Tables\Actions\DeleteAction::make(),
            // ])
            // ->bulkActions([
            //     // Tables\Actions\BulkActionGroup::make([
            //     //     Tables\Actions\DeleteBulkAction::make(),
            //     // ]),
            // ]);
      
            
    }
}
