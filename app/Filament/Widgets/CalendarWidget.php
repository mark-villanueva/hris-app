<?php
 
 namespace App\Filament\Widgets;

 use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;
 use App\Models\Event;
 use Illuminate\Database\Eloquent\Model;
 use Saade\FilamentFullCalendar\Actions;
 use Saade\FilamentFullCalendar\Actions\CreateAction;
 use Filament\Forms;
 use Filament\Forms\Form;

 class CalendarWidget extends FullCalendarWidget
 {
     public Model | string | null $model = Event::class;

     protected function headerActions(): array
    {
        return [
            Actions\CreateAction::make()
             ->mountUsing(
                 function (Forms\Form $form, array $arguments) {
                     $form->fill([
                         'starts_at' => $arguments['start'] ?? null,
                         'ends_at' => $arguments['end'] ?? null
                     ]);
                 }
             )
        ];
    }
 
    protected function modalActions(): array
    {
        return [
            Actions\EditAction::make()
             ->mountUsing(
                 function (Event $record, Forms\Form $form, array $arguments) {
                     $form->fill([
                         'name' => $record->name,
                         'starts_at' => $arguments['event']['start'] ?? $record->starts_at,
                         'ends_at' => $arguments['event']['end'] ?? $record->ends_at
                     ]);
                 }
             ),
            Actions\DeleteAction::make(),
        ];
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
             Forms\Components\TextInput::make('name'),
 
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
                        //  'url' => EventResource::getUrl(name: 'view', parameters: ['record' => $event]),
                        //  'shouldOpenUrlInNewTab' => true
                     ]
                 )
                 ->all();
         }
     }
 