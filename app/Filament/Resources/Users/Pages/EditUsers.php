<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UsersResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;

class EditUsers extends EditRecord
{
    protected static string $resource = UsersResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->before(function ($record) {

                    if ($record->is_active === 'Online') {

                        Notification::make()
                            ->title('Users tidak bisa dihapus')
                            ->body('Users sedang login.')
                            ->danger()
                            ->send();

                        $this->halt();
                    }
                }),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
