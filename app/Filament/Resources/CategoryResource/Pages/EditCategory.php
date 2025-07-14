<?php

namespace App\Filament\Resources\CategoryResource\Pages;

use App\Filament\Resources\CategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;

class EditCategory extends EditRecord
{
    protected static string $resource = CategoryResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotification(): ?Notification
    {
        return null;
    }

    protected function afterSave()
    {
        return Notification::make()
            ->title('Category updated')
            ->body('La categoría ha sido actualizada correctamente.')
            ->icon('heroicon-o-check-circle')
            ->success();
    }


    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->successNotification(
                    Notification::make()
                        ->title('Category deleted successfully')
                        ->body('Categoria eliminada')
                        ->success()
                )
        ];
    }
}
