<?php

namespace App\Livewire\Pkl;

use Livewire\Component;
use App\Models\Pkl;

class View extends Component
{
    public $pkl; // menyimpan data PKL yang diambil dari database
    public $pklId; // menyimpan ID PKL yang diterima dari URL

    // dijalankan otomatis saat komponen di-load, ini yang awal pertama 
    public function mount($id) // dikirim dari URL 
    {
        $this->pklId = $id; 
        $this->pkl = Pkl::findOrFail($id); // Gmencari data PKL berdasarkan id, jika tidak ketemu, Laravel otomatis akan menampilkan error 404
    }

    public function render()
    {
        return view('livewire.pkl.view', [
            'pkl' => $this->pkl
        ]);
    }
}
