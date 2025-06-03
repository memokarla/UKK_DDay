<?php

namespace App\Livewire\Industri;

use Livewire\Component;
use App\Models\Industri;
use Livewire\WithFileUploads; // diperlukan untuk fitur upload file

class Create extends Component
{
    use WithFileUploads; // mengaktifkan fitur upload file

    public $foto, $nama, $bidang_usaha, $website, $alamat, $kontak, $email;

    // fungsi yang akan dipanggil ketika user menekan button Tambahkan, kan di buttton view ada wire:click="create", nah itu ini
    public function create() {
        $this->validate([ // ini semua validasi input
            'foto' => 'required|image|max:2048', // harus file foto, maximal 2mb
            'nama' => 'required',
            'bidang_usaha' => 'required',
            'website' => 'required|url', // berupa url
            'alamat' => 'required',
            'kontak' => 'required|numeric', // hanya menerima angka
            'email' => 'required|email', // hanya menerima dalam formal email
        ]);

        // menyimpan file gambar ke folder storage/app/public/industri, dan menyimpan path-nya ke variabel $fotoPath
        $fotoPath = $this->foto->store('industri', 'public');
        
        // menyimpan data industri baru ke database dengan field yang sudah divalidasi 
        Industri::create([
            'foto' => $fotoPath, // file path foto yang sudah diupload
            'nama' => $this->nama,
            'bidang_usaha' => $this->bidang_usaha,
            'website' => $this->website,
            'alamat' => $this->alamat,
            'kontak' => $this->kontak,
            'email' => $this->email,
        ]);

        session()->flash('success', 'Industri berhasil ditambahkan!');
        return redirect('/industri');
    }

    public function render()
    {
        return view('livewire.industri.create');
    }
}
