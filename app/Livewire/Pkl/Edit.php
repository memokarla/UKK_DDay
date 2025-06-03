<?php

namespace App\Livewire\Pkl;

use Livewire\Component;
use App\Models\Pkl;
use App\Models\Siswa;
use App\Models\Guru;
use App\Models\Industri;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class Edit extends Component
{
    public $pklId;
    public $siswa_id, $guru_id, $industri_id; // ini menyesuaikan mount
    public $mulai, $selesai;

    public function mount($id)
    {
        $this->pklId = $id;
        $pkl = Pkl::findOrFail($id); 

        // jika pengguna telah login dengan email yang TIDAK SAMA DENGAN email siswa yang login, maka abort
        if (Auth::user()->email !== $pkl->siswa->email) {
            abort(403, 'Anda tidak memiliki izin untuk mengedit data ini.');
        }
    
        // Isi value awal form
        $this->siswa_id = $pkl->siswa_id;
        $this->guru_id = $pkl->guru_id;
        $this->industri_id = $pkl->industri_id;
        $this->mulai = $pkl->mulai;
        $this->selesai = $pkl->selesai;
    }

    public function update()
    {
        $this->validate([ // ini semua validasi input
            'siswa_id' => 'required|exists:siswas,id',
            'guru_id' => 'required|exists:gurus,id',
            'industri_id' => 'required|exists:industris,id',
            'mulai' => 'required|date',
            'selesai' => ['required', 'date', 'after_or_equal:mulai', // Tanggal selesai harus setelah atau sama dengan tanggal mulai
                         function ($attribute, $value, $fail) {
                            $mulai = Carbon::parse($this->mulai);       // $attribute
                            // mengubah nilai tanggal mulai ($this->mulai) menjadi Carbon, agar bisa diproses tanggalnya (misalnya dihitung selisih bulan)
                            $selesai = Carbon::parse($value);           // $values
                            // mengubah nilai tanggal selesai ($value) menjadi Carbon
                            if ($mulai->diffInMonths($selesai) < 3) {   // $fail
                            // menghitung jumlah bulan penuh antara tanggal mulai dan selesai
                            // jika: durasi PKL kurang dari 3 bulan
                                $fail('Durasi PKL minimal 3 bulan');
                                // maka: panggil fungsi $fail dengan pesan error sehingga validasi gagal dan pesan ini akan ditampilkan ke user
                            }   
                         }],
        ]);

        // Mengecek apakah siswa sudah terdaftar di PKL
        $siswaTerdaftar = Pkl::where('siswa_id', $this->siswa_id)
            ->where('id', '!=', $this->pklId) // jangan hitung data yang sedang diedit
            ->exists();
        
        if ($siswaTerdaftar) {
            session()->flash('error', 'Siswa ini sudah terdaftar di PKL');
            return;
        }

        $pkl = Pkl::findOrFail($this->pklId);

        $pkl->update([
            'siswa_id' => $this->siswa_id,
            'guru_id' => $this->guru_id,
            'industri_id' => $this->industri_id,
            'mulai' => $this->mulai,
            'selesai' => $this->selesai,
        ]);

        session()->flash('message', 'Data PKL Berhasil Diupdate.');
        return redirect('/dataPkl');
    }

    public function render()
    {
        return view('livewire.pkl.edit', [
            'siswas' => Siswa::all(),
            'gurus' => Guru::all(),
            'industris' => Industri::all(),
        ]);
    }
}
