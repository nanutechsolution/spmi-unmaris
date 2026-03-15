<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use App\Enums\NavigationGroup as NavigationGroupEnum;
use App\NavigationGroupEnum as AppNavigationGroupEnum;
use Filament\Pages\Page;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Notifications\Notification;
use Filament\Actions\Action;
use Filament\Support\Exceptions\Halt;
use BackedEnum;

class ManageSettings extends Page implements HasForms
{
    use InteractsWithForms;

    // Type hinting sesuai standar Filament/Modern PHP
    protected static ?string $title = 'Konfigurasi API';
    protected static string | \UnitEnum | null $navigationGroup = AppNavigationGroupEnum::SETTINGS->value;

    protected static ?string $navigationLabel = 'Pengaturan Sistem';

    protected static ?int $navigationSort = 3;

    protected  string $view = 'filament.pages.manage-settings';

    /**
     * Data state untuk form
     * @var array<string, mixed>|null
     */
    public ?array $data = [];

    /**
     * Inisialisasi data saat halaman dimuat
     */
    public function mount(): void
    {
        $this->form->fill([
            'siakad_url' => Setting::get('siakad_url', config('services.siakad.url')),
            'sima_api_key' => Setting::get('sima_api_key', config('services.siakad.api_key')),
            'cache_duration' => Setting::get('cache_duration', 60),
        ]);
    }

    /**
     * Definisi struktur form menggunakan Filament\Schemas\Schema
     */
    public function form(Schema $form): Schema
    {
        return $form
            ->schema([
                Section::make('Integrasi SIAKAD')
                    ->description('Pengaturan koneksi utama ke Identity Provider (SIAKAD)')
                    ->schema([
                        TextInput::make('siakad_url')
                            ->label('URL Server SIAKAD')
                            ->helperText('Contoh: http://localhost:8001 (tanpa slash di akhir)')
                            ->url()
                            ->required(),

                        TextInput::make('sima_api_key')
                            ->label('X-SIMA-KEY')
                            ->helperText('Kunci rahasia yang harus sama dengan konfigurasi di SIAKAD')
                            ->password()
                            ->revealable()
                            ->required(),

                        Select::make('cache_duration')
                            ->label('Durasi Cache Data (Menit)')
                            ->options([
                                '0' => 'Tanpa Cache (Selalu Real-time)',
                                '30' => '30 Menit',
                                '60' => '1 Jam',
                                '1440' => '24 Jam',
                            ])
                            ->default('60')
                            ->required(),
                    ])->columns(2),
            ])
            ->statePath('data');
    }

    /**
     * Actions yang muncul di header halaman
     */
    protected function getHeaderActions(): array
    {
        return [
            Action::make('seed_default')
                ->label('Seed Default')
                ->icon('heroicon-o-arrow-path')
                ->color('gray')
                ->requiresConfirmation()
                ->action(function () {
                    Setting::updateOrCreate(['key' => 'siakad_url'], ['value' => 'http://localhost:8001', 'group' => 'api']);
                    Setting::updateOrCreate(['key' => 'sima_api_key'], ['value' => 'kunci_rahasia_siakad', 'group' => 'api']);

                    $this->mount();

                    Notification::make()
                        ->title('Data Seeded')
                        ->success()
                        ->send();
                }),
        ];
    }

    /**
     * Mendefinisikan aksi form (Tombol Simpan)
     */
    public function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label('Simpan Perubahan')
                ->color('primary')
                ->submit('save'),
        ];
    }

    /**
     * Logika penyimpanan data
     */
    public function save(): void
    {
        try {
            $data = $this->form->getState();

            foreach ($data as $key => $value) {
                Setting::updateOrCreate(
                    ['key' => $key],
                    [
                        'value' => $value,
                        'group' => 'api'
                    ]
                );
            }

            Notification::make()
                ->title('Pengaturan Berhasil Disimpan')
                ->success()
                ->send();
        } catch (Halt $exception) {
            return;
        }
    }
}
