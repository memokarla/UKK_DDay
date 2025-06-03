<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class MenungguAkses extends Component
{
    // satu kali dipanggil, dan pertama kali yang akan dimuat ketika membuka livewire
    // isinya kan sama nih dengan function checkRoles, tujuan dari function mount yang ini adalah
                // agar user yang sudah punya role tapi masih iseng buka /menungguAksesAdmin, langsung diarahkan ke dashboard tanpa harus tunggu 5 detik
    public function mount() 
    {
        // cek saat komponen dipasang (dimuat)
        if (Auth::user()->roles->isNotEmpty()) {
            return redirect()->route('dashboard'); // dengan return ini, akan langsung mengembalikan redirect ke dashboard
        }
    }

    // fungsi untuk polling cek role tiap beberapa detik
    // ini yang akan dipanggil di viewnya
    // function ini akan dijalankan berkali-kali via wire:poll tiap 5 detik (ini aku setting 5 detik, jadi sebenarnya bebas)
    // jadi livewire akan memanggil fungsi ini setiap 5 detik sekali untuk ngecek apakah user sudah dapat role dari admin
    // jadi tujuannya adalah 
                // kalau role diberikan saat halaman ini sedang dibuka, user akan otomatis diarahkan ke dashboard begitu rolenya muncul.
    public function checkRoles()
    {
        if (Auth::user()->roles->isNotEmpty()) {
            $this->redirectRoute('dashboard');  
            // ini kan make $this nih, nah ini merupakan fitur livewire, bukan laravelnya
            // dengan menggunakan ini, functionnya dapat digunakan di viewnya, di event livewire, seperti button, atau dalam konteks ini adalah polling
        }
    }

    public function render()
    {
        return view('livewire.menunggu-akses');
    }
}
