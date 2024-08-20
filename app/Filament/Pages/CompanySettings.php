<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Models\Company;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Livewire\Component;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Forms\Components\Section;

class CompanySettings extends Page implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];
    public ?Company $company = null;

    protected static ?int $navigationSort = 1;
    protected static ?string $title = 'Company';
    protected static ?string $navigationLabel = 'Company';
    protected ?string $heading = 'Company';
    protected static ?string $navigationGroup = 'Company Settings';

    protected static string $view = 'filament.pages.company-settings';

    public function mount(): void
    {
        $this->company = $this->getCompany();
        $this->form->fill($this->company->toArray());
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('')
                    ->schema([
                        Forms\Components\TextInput::make('company_name')
                            ->placeholder('Type your company name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('trade_name')
                            ->placeholder('Type your company trade name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Select::make('type')
                            ->options([
                                'Private' => 'Private',
                                'Government' => 'Government',
                                'Non-Profit' => 'Non-Profit',
                            ])
                            ->native(false),
                        Forms\Components\TextInput::make('tin')
                            ->placeholder('000-000-000-000')
                            ->label('TIN'),
                        Forms\Components\TextInput::make('rdo')
                            ->placeholder('049')
                            ->label('RDO'),
                        Forms\Components\TextInput::make('sss')
                            ->placeholder('00-0000000-0')
                            ->label('SSS'),
                        Forms\Components\TextInput::make('hdmf')
                            ->placeholder('0000-0000-0000')
                            ->label('HDMF'),
                        Forms\Components\TextInput::make('philhealth')
                            ->placeholder('00-000000000-0')
                            ->label('PhilHealth'),
                    ])
            ])
            ->statePath('data')
            ->model(Company::class);
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
        $this->company->fill($validatedData);
        $this->company->save();

        // Handle media file upload
        if (isset($validatedData['attachments'])) {
            $this->company->clearMediaCollection('attachments');
            $this->company->addMedia($validatedData['attachments'])
                ->toMediaCollection('attachments');
        }

        Notification::make()
            ->success()
            ->title('Company Settings Saved Successfully')
            ->send();
    }

    protected function getCompany(): Company
    {
        // Assuming you're working with a single company. Adjust as necessary.
        return Company::firstOrNew(['id' => 1]);
    }
}
