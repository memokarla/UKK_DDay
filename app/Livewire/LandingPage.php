<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Siswa;
use App\Models\Guru;
use App\Models\Industri;

class LandingPage extends Component
{
    public $jumlahSiswa;
    public $jumlahGuru;
    public $jumlahIndustri;

    public function mount()
    {
        $this->jumlahSiswa = Siswa::count();
        $this->jumlahGuru = Guru::count();
        $this->jumlahIndustri = Industri::count();
    }

    public function render()
    {
        $industris = Industri::all();

        return view('livewire.landing-page', compact('industris'));
    }
}
