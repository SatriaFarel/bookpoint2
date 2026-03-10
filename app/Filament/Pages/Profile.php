<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Notifications\Notification;
use Filament\Support\Icons\Heroicon;
use BackedEnum;
use Dom\Text;

class Profile extends Page
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedArchiveBox;
    protected string $view = 'filament.pages.profile';

    protected static ?int $navigationSort = 1;

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill([
            'image' => auth()->user()->image, // HARUS path relatif
            'name'  => auth()->user()->name,
            'email' => auth()->user()->email,
            'role' => auth()->user()->role,
        ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([

                FileUpload::make('image')
                    ->label('Profile Photo')
                    ->image()
                    ->avatar()
                    ->disk('public') // pakai disk public
                    ->directory('profile-photos')
                    ->visibility('public') // WAJIB
                    ->maxSize(2048) // 2MB
                    ->imageEditor(true), // matikan dulu biar stabil

                TextInput::make('no_rekening')
                    ->label('No. Rekening')
                    ->required(),

                TextInput::make('name')
                    ->required(),

                TextInput::make('email')
                    ->email()
                    ->required(),
                
                TextInput::make('password')
                    ->password()
                    ->label('New Password')
                    ->dehydrated(false), // jangan simpan password kosong

                TextInput::make('role')
                    ->disabled()
                    ->label('Role'),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $user = auth()->user();

        $user->update($this->form->getState());

        Notification::make()
            ->title('Profile berhasil diperbarui')
            ->success()
            ->send();
    }

    public static function canAccess(): bool
    {
        return false;
    }


}
