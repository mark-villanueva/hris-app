<?php
 
 namespace App\Filament\Widgets;

 use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;
 use App\Models\Event;
 use Illuminate\Database\Eloquent\Model;
 use Saade\FilamentFullCalendar\Actions;
 use Saade\FilamentFullCalendar\Actions\CreateAction;
 use Saade\FilamentFullCalendar\Actions\EditAction;
 use Saade\FilamentFullCalendar\Actions\DeleteAction;
 use Filament\Forms;
 use Filament\Forms\Form;
 
 class CalendarWidget extends FullCalendarWidget
 {
     protected static ?int $sort = 3;
 
     public Model | string | null $model = Event::class;
 
     protected function headerActions(): array
     {
         $actions = [];
 
         if (auth()->check() && auth()->user()->id == 1) {
             $actions[] = Actions\CreateAction::make()
                 ->label('Add Holidays')
                 ->mountUsing(
                     function (Forms\Form $form, array $arguments) {
                         $form->fill([
                             'starts_at' => $arguments['start'] ?? null,
                             'ends_at' => $arguments['end'] ?? null
                         ]);
                     }
                 );
         }
 
         return $actions;
     }
 
     protected function modalActions(): array
     {
         $actions = [];
 
         if (auth()->check() && auth()->user()->id == 1) {
             $actions[] = Actions\EditAction::make()
                 ->mountUsing(
                     function (Event $record, Forms\Form $form, array $arguments) {
                         $form->fill([
                             'name' => $record->name,
                             'starts_at' => $arguments['event']['start'] ?? $record->starts_at,
                             'ends_at' => $arguments['event']['end'] ?? $record->ends_at
                         ]);
                     }
                 );
 
             $actions[] = Actions\DeleteAction::make();
         }
 
         return $actions;
     }
 
     public function eventDidMount(): string
     {
         return <<<JS
             function({ event, timeText, isStart, isEnd, isMirror, isPast, isFuture, isToday, el, view }){
                 el.setAttribute("x-tooltip", "tooltip");
                 el.setAttribute("x-data", "{ tooltip: '"+event.title+"' }");
             }
         JS;
     }
 
     public function getFormSchema(): array
     {
         return [
             Forms\Components\TextArea::make('name')
                ->label('Holiday'),
 
             Forms\Components\Grid::make()
                 ->schema([
                     Forms\Components\DatePicker::make('starts_at'),
                     Forms\Components\DatePicker::make('ends_at'),
                 ]),
         ];
     }
 
     public function fetchEvents(array $fetchInfo): array
     {
         return Event::query()
             ->where('starts_at', '>=', $fetchInfo['start'])
             ->where('ends_at', '<=', $fetchInfo['end'])
             ->get()
             ->map(
                 fn (Event $event) => [
                     'id' => $event->id,
                     'title' => $event->name,
                     'start' => $event->starts_at,
                     'end' => $event->ends_at,
                     // 'url' => EventResource::getUrl(name: 'view', parameters: ['record' => $event]),
                     // 'shouldOpenUrlInNewTab' => true
                 ]
             )
             ->all();
     }
 }