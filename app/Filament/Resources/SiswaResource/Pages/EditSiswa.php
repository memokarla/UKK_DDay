<?php

namespace App\Filament\Resources\SiswaResource\Pages;

use App\Filament\Resources\SiswaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSiswa extends EditRecord
{
    protected static string $resource = SiswaResource::class;
    protected string $previousEmail;

    // method untuk nemapilin action di edit form
    protected function getHeaderActions(): array
    {
        // membuat array $actions yang berisi satu tombol, yaitu tombol View
        // karena view sudah pasti ada, baik status aktif maupun tidak
        $actions = [
            Actions\ViewAction::make(),
        ];

        // TANTANGAN: action delete hada hanya jika status non aktif
        // nah, barulah kita membuat kodnisi
        if (! $this->record->status_lapor_pkl) {
        // $this->record adalah data siswa yang sedang diedit sekarang
        // status_lapor_pkl adalah field di database yang menunjukkan apakah siswa sedang aktif atau tidak
        // dengan adanya pentung, maka, JIKA status_lapor_pkl false (artinya siswa belum aktif), maka jalankan kode di dalam if
            $actions[] = Actions\DeleteAction::make();
            //  menambahkan tombol Delete ke daftar tombol $actions
        }

        return $actions;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
