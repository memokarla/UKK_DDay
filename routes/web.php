<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('landingPage');
});

Route::get('/menungguAksesAdmin', App\Livewire\MenungguAkses::class)
    ->middleware('auth')
    ->name('menungguAdmin');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    // nah, CheckUserRoles ini merupakan nama alias yang sudah kita daftarkan di bootstrap/app.php tadi
    // super_admin dan siswanya merupakan parameter (nilai)
    'CheckUserRoles:super_admin', 
    'CheckUserRoles:siswa', 
])->group(function () {
    // Route::get('/dashboard', function () {
    //     return view('dashboard');
    // })->name('dashboard');

    Route::get('/dashboard', App\Livewire\Dashboard\Index::class)->name('dashboard');

    // PKL
    Route::get('/dataPkl', App\Livewire\Pkl\Index::class)->name('pkl');
    Route::get('/dataPkl/tambah', App\Livewire\Pkl\Create::class)->name('pklCreate');
    Route::get('/dataPkl/{id}', App\Livewire\Pkl\View::class)->name('pklView');
    Route::get('/dataPkl/{id}/edit', App\Livewire\Pkl\Edit::class)->name('pklEdit');

    // Guru
    Route::get('/guru', App\Livewire\Guru\Index::class)->name('guru');

    // Siswa
    Route::get('/siswa', App\Livewire\Siswa\Index::class)->name('siswa');

    // Industri
    Route::get('/industri', App\Livewire\Industri\Index::class)->name('industri');
    Route::get('/industri/tambah', App\Livewire\Industri\Create::class)->name('industriCreate');
});
