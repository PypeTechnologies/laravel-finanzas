<?php

namespace App\Filament\Resources\CategoryResource\Pages;

use App\Filament\Resources\CategoryResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateCategory extends CreateRecord
{
    protected static string $resource = CategoryResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->body('La categoría ha sido guardada correctamente.')
            ->icon('heroicon-o-check-circle')
            ->iconColor('success')
            ->send();
    }

    protected function getFormActions(): array
    {
        return [
            $this->getCreateFormAction()
                ->label('Guardar'),
            $this->getCancelFormAction()
                ->label('Cancelar')
                ->color('success')
                ->icon('heroicon-o-x-circle'),
            /*$this->getCreateAnotherFormAction()
                ->label('Guardar y crear otra')
                ->icon('heroicon-o-plus-circle'),*/

        ];
    }
}
