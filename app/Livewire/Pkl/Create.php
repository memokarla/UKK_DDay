<?php

namespace App\Livewire\Pkl;

use Livewire\Component;
use App\Models\Pkl;
use App\Models\Siswa;
use App\Models\Guru;
use App\Models\Industri;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Create extends Component
{
    public $siswa_id, $guru_id, $industri_id, $mulai, $selesai;

    // menyimpan nama siswa yang sedang login
    public $nama_siswa;

    // otomatis dijalankan saat komponen Livewire dibuat, mount ini yang pertama
    public function mount()
    {

        // ambil email user yang sedang login
        // ini mengambil data dari tabel users
        // sistem autentikasi Laravel secara default menggunakan model App\Models\User yang terkait langsung dengan tabel users
        $userEmail = Auth::user()->email;

        // cari data siswa berdasarkan email
        // Siswa::where('email', $userEmail) : berarti, pada model Siswa, pada database siswas, cari email berdasarkan $userEmail (mengambil email user yang sedang login)
        // nilainya akan disimpan di $siswa
        $siswa = Siswa::where('email', $userEmail)->first();

        // email cocok (di $siwa tadi)
        if ($siswa) {
            // aka:
            // simpan ID siswa ($siswa->id) ke $siswa_id (dipakai untuk input form tersembunyi)
            $this->siswa_id = $siswa->id;
            // simpan nama ($siswa->nama) ke $nama_siswa (dipakai untuk ditampilkan)
            $this->nama_siswa = $siswa->nama;
        }
    }

    // fungsi yang akan dipanggil ketika user menekan button Tambahkan, kan di buttton view ada wire:click="create", nah itu ini
    public function create() {
        $this->validate([ // ini semua validasi input
            // nah, nama validani ini juga disesuaikan dari wire:model di blade
            'siswa_id' => 'required|exists:siswas,id',
                // 'siswa_id' => Nama field/input yang sedang divalidasi
                // exists:gurus,id (format: exists:table,column) 
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

        //  mulai transaksi database – supaya semua query berikutnya dijalankan bersama, dan bisa di-rollback kalau terjadi error
        DB::beginTransaction();

        try {
            // ambil data siswa berdasarkan siswa_id. Jika tidak ditemukan, akan otomatis gagal (404)
            $siswa = Siswa::findOrFail($this->siswa_id);

            // cek apakah siswa sudah pernah melaporkan PKL sebelumnya (status_lapor_pkl == 1)
            if ($siswa->status_lapor_pkl) {
                DB::rollBack(); // jika ada, data akan di rollback (membatalkan semua perubahan database) dengan memunculkan pesan di bawah ini (harus dipanggil dulu)
                                // kan tadi udah dilakukan DB::beginTransaction();, maka rollBack() ini akan mengembalikan database ke kondisi sebelum transaksi dimulai
                session()->flash('error', 'Transaksi dibatalkan: Siswa sudah memiliki data PKL.'); // nah ini pesan error nya
                return redirect('/dataPkl'); // mengarahkan user kembali ke /dataPkl
            }

            // simpan data PKL baru ke database
            Pkl::create([
                'siswa_id' => $this->siswa_id,
                'guru_id' => $this->guru_id,
                'industri_id' => $this->industri_id,
                'mulai' => $this->mulai,
                'selesai' => $this->selesai,
            ]);

            // simpan transaksi secara permanen ke database (commit semua perubahan)
            DB::commit();

            session()->flash('success', 'Data PKL berhasil ditambahkan!'); // pesan suksesnya
            return redirect('/dataPkl'); // kembali ke /dataPkl

        } catch (\Exception $e) { // tangkap semua error yang mungkin terjadi selama proses penyimpanan
            DB::rollBack(); // membatalkan semua perubahan
            session()->flash('error', 'Terjadi kesalahan saat menyimpan data.'); // ini pesannya
            return;
        }
    }

    public function render()
    {
        // Ambil semua data guru, industri untuk dropdown (tanpa filter pencarian)
        $pkls = Pkl::all(); 
        // $siswas = Siswa::all(); 
        $gurus = Guru::all();
        $industris = Industri::all();

        return view('livewire.pkl.create', [
            'pkls' => $pkls,
            // 'siswas' => $siswas,
            'gurus' => $gurus,
            'industris' => $industris,
        ]);

        // $siswas = Siswa::all(); 
        // 'siswas' => $siswas,
        // di komenkan, karena kemarin digunakan untuk dropwodn, nampilin SEMUA namanya, namun sekarang SATU nama berdasarkan login
    }
}
