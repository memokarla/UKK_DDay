<?php

namespace App\Filament\Resources\IndustriResource\Pages;

use App\Filament\Resources\IndustriResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditIndustri extends EditRecord
{
    protected static string $resource = IndustriResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make()
            ->before(function ($record, \Filament\Actions\DeleteAction $action) {
                    if ($record->pkl()->exists()) {
                        \Filament\Notifications\Notification::make()
                            ->title('Gagal menghapus!')
                            ->body('Industri ini masih digunakan dalam PKL. Hapus PKL terkait terlebih dahulu.')
                            ->danger()
                            ->send();

                        $action->halt(); // hentikan eksekusi tanpa error
                    }
                }),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
