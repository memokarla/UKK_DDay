<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Models\Siswa;
use App\Models\Guru;
use App\Models\Industri;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Index extends Component
{
    public $jumlahGuru;
    public $jumlahSiswa;
    public $jumlahIndustri;
    public $chartData;
    public $chartDataRombelA;
    public $chartDataRombelB;
    public $chartDataIndustri;

    // as we know ya, saat komponen livewire dipanggil, ini akan dipanggil otomatis
    public function mount()
    {
        $this->loadDashboardData(); 
        $this->loadChartData(); // ini merupakan function yang kita panggil, setelah kita membuatnya di bawah ini
        $this->loadChartDataRombelA(); 
        $this->loadChartDataRombelB(); 
        $this->loadChartDataIndustri(); 
    }

    public function loadDashboardData()
    {
        $this->jumlahGuru = Guru::count();
        $this->jumlahSiswa = Siswa::count();
        $this->jumlahIndustri = Industri::count();
    }

    // ini fungsi yang kita buat, jadi namanya custom, bisa saja ambilData
    public function loadChartData()
    {
        // pada model Siswa yang membaca database siswas, ambil rombel dengan data SIJA A, dan yang memiliki status_lapor_pkl true, simpah ke $sijaA_sudah
        $sijaA_sudah = Siswa::where('rombel', 'SijaA')->where('status_lapor_pkl', true)->count();

        // pada model Siswa yang membaca database siswas, ambil rombel dengan data SIJA B, dan yang memiliki status_lapor_pkl true, simpah ke $sijaB_sudah
        $sijaB_sudah = Siswa::where('rombel', 'SijaB')->where('status_lapor_pkl', true)->count();

        // pada model Siswa yang membaca database siswas, ambil yang memiliki status_lapor_pkl false, simpah ke $belum
        $belum = Siswa::where('status_lapor_pkl', false)->count();

        // lalu, ketiga data ini disimpan ke properti Livewire 'chartData'
        $this->chartData = [
            ['Kategori', 'Jumlah'],
            ['SIJA A - Sudah', $sijaA_sudah],
            ['SIJA B - Sudah', $sijaB_sudah],
            ['Belum Isi', $belum],
        ];
    }

    public function loadChartDataRombelA()
    {
        // pada model Siswa yang membaca database siswas, ambil rombel dengan data SIJA A, dan yang memiliki status_lapor_pkl true, simpah ke $sijaA_sudah
        $sijaA_sudah = Siswa::where('rombel', 'SijaA')->where('status_lapor_pkl', true)->count();
        $sijaA_belum = Siswa::where('rombel', 'SijaA')->where('status_lapor_pkl', false)->count();

        $this->chartDataRombelA = [
            ['Kategori', 'Jumlah'],
            ['SIJA A - Sudah', $sijaA_sudah],
            ['SIJA A - Belum', $sijaA_belum],
        ];
    }

    public function loadChartDataRombelB()
    {
        // pada model Siswa yang membaca database siswas, ambil rombel dengan data SIJA A, dan yang memiliki status_lapor_pkl true, simpah ke $sijaA_sudah
        $sijaB_sudah = Siswa::where('rombel', 'SijaB')->where('status_lapor_pkl', true)->count();
        $sijaB_belum = Siswa::where('rombel', 'SijaB')->where('status_lapor_pkl', false)->count();

        $this->chartDataRombelB = [
            ['Kategori', 'Jumlah'],
            ['SIJA B - Sudah', $sijaB_sudah],
            ['SIJA B - Belum', $sijaB_belum],
        ];
    }

    public function loadChartDataIndustri()
    {
        // ambil data dari table pkls
        $data = DB::table('pkls')
            // join() menggabungkan dengan tabel industris berdasarkan industri_id, kan di table pkls ada fk berupa ini
            ->join('industris', 'pkls.industri_id', '=', 'industris.id')    // sintaknya    = $table, Tabel yang ingin dijoin (industris)
                                                                            //              = $first, Kolom dari tabel utama (pkls.industri_id')
                                                                            //              = $operator, Operator perbandingan (=, !=, dll.) (= membandingkan apakah sama)
                                                                            //              = $second, Kolom dari tabel yang dijoin (industris.id)
            // memilih nama industri dan menghitung total siswa (count(pkls.siswa_id))
            ->select('industris.nama as industri', DB::raw('count(pkls.siswa_id) as jumlah_siswa')) 
            // mengelompokkan berdasarkan industri agar per-industri dihitung jumlah siswanya
            ->groupBy('industris.id', 'industris.nama')
            ->get();

        // header grafik: kolom pertama "Industri", kolom kedua "Jumlah Siswa"
        $this->chartDataIndustri = [['Industri', 'Jumlah Siswa']];

        // setiap baris ditambahkan ke chartDataIndustri dalam format: ['Nama Industri', jumlah_siswa]
        foreach ($data as $row) {
            $this->chartDataIndustri[] = [$row->industri, $row->jumlah_siswa];
        }
    }

    public function render()
    {
        // ambil email user yang sedang login
        // ini mengambil data dari tabel users
        // sistem autentikasi Laravel secara default menggunakan model App\Models\User yang terkait langsung dengan tabel users
        $userEmail = Auth::user()->email;

        // cari data siswa berdasarkan email
        // Siswa::where('email', $userEmail) : berarti, pada model Siswa, pada database siswas, cari email berdasarkan $userEmail (mengambil email user yang sedang login)
        // nilainya akan disimpan di $siswa
        $siswa = Siswa::where('email', $userEmail)->first();

        return view('livewire.dashboard.index', [
            'siswa' => $siswa,
            'jumlahGuru' => $this->jumlahGuru,
            'jumlahSiswa' => $this->jumlahSiswa,
            'jumlahIndustri' => $this->jumlahIndustri,
            'chartData' => $this->chartData,
            'chartDataRombelA' => $this->chartDataRombelA,
            'chartDataRombelB' => $this->chartDataRombelB,
            'chartDataIndustri' => $this->chartDataIndustri,
        ]);
    }
}
