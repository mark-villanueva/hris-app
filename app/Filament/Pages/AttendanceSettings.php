<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Models\Attendance;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Livewire\Component;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Forms\Components\Section;

class AttendanceSettings extends Page implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];
    public ?Attendance $attendance = null;

    protected static ?int $navigationSort = 1;
    protected static ?string $navigationGroup = 'Time & Attendance';

    protected static string $view = 'filament.pages.attendance-settings';

    public function mount(): void
    {
        $this->attendance = $this->getAttendance();
        $this->form->fill($this->attendance->toArray());
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('')
                    ->schema([
                        Forms\Components\TextInput::make('maximum_pairing_hours')
                            ->hintIcon('heroicon-m-question-mark-circle', tooltip: 'The maximum number of hours that the system will pair in number of hours.')
                            ->numeric()
                            ->required(),
                        Forms\Components\TextInput::make('minimum_pairing_range')
                            ->hintIcon('heroicon-m-question-mark-circle', tooltip: 'The minimum number of minutes that the system will pair.')
                            ->numeric()
                            ->numeric()
                            ->required(),
                        Forms\Components\TimePicker::make('night_shift_differential_start')
                            ->hintIcon('heroicon-m-question-mark-circle', tooltip: 'Night shift differential pay is an additional pay for work between 6:00 p.m. and 6:00 a.m. the following day for those in the Government Service, and between 10:00 p.m. and 6:00 a.m. the following day for those in the private sector.')
                            ->seconds(false)
                            ->required(),
                        Forms\Components\TimePicker::make('night_shift_differential_end')
                            ->seconds(false)
                            ->required(),
                        Forms\Components\Checkbox::make('automatically_mark_absent')
                            ->helperText('Automatically mark absent if no timesheet entry')
                            ->required(),
                       
                    ])
                    ->columns(2)
            ])
            ->statePath('data')
            ->model(Attendance::class);
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label(__('filament-panels::resources/pages/edit-record.form.actions.save.label'))
                ->submit('save'),
        ];
    }

    public function save(): void
    {
        $validatedData = $this->form->getState();
        $this->attendance->fill($validatedData);
        $this->attendance->save();

        Notification::make()
            ->success()
            ->title('Attendance Settings Saved Successfully')
            ->send();
    }

    protected function getAttendance(): Attendance
    {
        // Assuming you're working with a single attendance. Adjust as necessary.
        return Attendance::firstOrNew(['id' => 1]);
    }
}