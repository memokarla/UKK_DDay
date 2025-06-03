<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;
    protected string $previousEmail;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $this->previousEmail = $this->record->email;
        return $data;
    }

    protected function afterSave(): void
    {
        $siswa = \App\Models\Siswa::where('email', $this->previousEmail)->first();

        if ($siswa) {
            $siswa->update([
                'email' => $this->record->email,
            ]);
        }
    }
}
