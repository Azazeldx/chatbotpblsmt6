<?php

namespace App\Filament\Pages\GeneralSettings;

use App\Filament\Forms\AIFieldsForm;
use App\Filament\Forms\AnalyticsFieldsForm;
use App\Filament\Forms\ApplicationFieldsForm;
use App\Filament\Forms\EmailFieldsForm;
use App\Filament\Forms\NavigationFieldsForm;
use App\Filament\Forms\SocialNetworkFieldsForm;
use App\Models\GeneralSetting;
use Filament\Actions;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\TestMail;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Filament\Support\Colors\Color;

class GeneralSettingsPage extends Page
{
    use HasPageShield;

    protected static string $view = 'filament.pages.general-settings-page';

    protected static ?string $slug = 'general-settings';

    protected static ?string $title = 'General Settings';
    protected static ?string $navigationLabel = 'General Settings';

    protected static ?string $navigationGroup = 'Settings';
    protected static ?int $navigationSort  = 1;

    protected static ?string $navigationIcon = 'heroicon-o-cog';

    public ?array $data = [];

    public function mount(): void
    {
        $this->data = GeneralSetting::first()?->toArray() ?: [];



        if ($this->data['theme']) {
            foreach ($this->data['theme'] as $key => $value) {
                $this->data['theme'][$key] = $value ? 'rgb('.$value[500].')' : null;
            }
        }

        $this->form->fill($this->data);
    }

    public function form(Form $form): Form
    {
        $arrTabs = [];

        $arrTabs[] = Tabs\Tab::make('Application')
            ->icon('heroicon-o-tv')
            ->schema(ApplicationFieldsForm::get())
            ->columns(3);

        $arrTabs[] = Tabs\Tab::make('Email')
            ->icon('heroicon-o-envelope')
            ->schema(EmailFieldsForm::get())
            ->columns(3)
            ->statePath('email_settings');

        $arrTabs[] = Tabs\Tab::make('Social Network')
            ->icon('heroicon-o-heart')
            ->schema(SocialNetworkFieldsForm::get())
            ->columns(2)
            ->statePath('social_network');

        $arrTabs[] = Tabs\Tab::make('Navigation')
            ->icon('heroicon-o-list-bullet')
            ->schema(NavigationFieldsForm::get())
            ->columns(['lg' => 3])
            ->statePath('navigation');

        if (!empty($this->data['features']['google_analytics'])) {
            $arrTabs[] = Tabs\Tab::make('Google Analytics')
                ->icon('heroicon-o-chart-bar')
                ->schema(AnalyticsFieldsForm::get())
                ->visible(fn ($get) => $get('features.google_analytics'))
                ->columns(['lg' => 3])
                ->statePath('google_analytics');
        }

        if (!empty($this->data['features']['ai'])) {
            $arrTabs[] = Tabs\Tab::make('AI')
                ->icon('heroicon-o-sparkles')
                ->schema(AIFieldsForm::get())
                ->visible(fn ($get) => $get('features.ai'))
                ->columns(['lg' => 3])
                ->statePath('ai');
        }

        return $form
            ->schema([
                Tabs::make('Tabs')
                    ->tabs($arrTabs),
            ])
            ->statePath('data');
    }

    protected function getFormActions(): array
    {
        return [
            Actions\Action::make('Save')
                ->color('primary')
                ->submit('Update'),
        ];
    }

    public function update(): void
    {
        $data = $this->form->getState();
        unset($data['mail_to']);

        foreach ($data['theme'] as $key => $value) {
            $data['theme'][$key] = $value ? Color::rgb($value) : null;
        }

        if ($data['navigation']['nav_items']) {
            foreach ($data['navigation']['nav_items'] as $key => $value) {
                if ($value['type'] == 'link') {
                    $data['navigation']['nav_items'][$key]['page'] = null;
                } else {
                    $data['navigation']['nav_items'][$key]['link'] = null;
                }
            }
        }

        GeneralSetting::updateOrCreate([], $data);

        $this->successNotification('Settings saved');
        redirect(request()?->header('Referer'));
    }

    public function sendTestMail(): void
    {
        $data = $this->form->getState();
        $email = $data['email_settings']['mail_to'];

        try {
            Mail::to($email)
                ->send(new TestMail([
                    'subject' => 'This is a test email to verify SMTP settings',
                    'body' => 'This is for testing email using smtp.',
                ]));
        } catch (\Exception $e) {
            $this->errorNotification('Email test error', $e->getMessage());

            return;
        }

        $this->successNotification('Email test success' . $email);
    }

    private function successNotification(string $title): void
    {
        Notification::make()
            ->title($title)
            ->success()
            ->send();
    }

    private function errorNotification(string $title, string $body): void
    {
        Log::error('[EMAIL] ' . $body);

        Notification::make()
            ->title($title)
            ->danger()
            ->body($body)
            ->send();
    }
}
