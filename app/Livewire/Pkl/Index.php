<?php

namespace App\Livewire\Pkl;

use Livewire\Component;
use App\Models\Pkl;
use App\Models\Siswa;
use App\Models\Guru;
use App\Models\Industri;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    protected $updatesQueryString = ['search'];
    protected $paginationTheme = 'tailwind';

    public $search = '';

    public function render()
    {
        // Ambil data PKL dan cari berdasarkan relasi
        $pklsQuery = Pkl::with(['siswa', 'guru', 'industri']);

        if (!empty($this->search)) {
            $pklsQuery->where(function ($query) {
                $query->whereHas('siswa', function ($q) {
                    $q->where('nis', 'like', '%' . $this->search . '%')
                        ->orWhere('nama', 'like', '%' . $this->search . '%');
                })
                ->orWhereHas('guru', function ($q) {
                    $q->where('nama', 'like', '%' . $this->search . '%');
                })
                ->orWhereHas('industri', function ($q) {
                    $q->where('nama', 'like', '%' . $this->search . '%')
                        ->orWhere('bidang_usaha', 'like', '%' . $this->search . '%');
                });
            });
        }

        $pkls = $pklsQuery->paginate(10);

        // Ambil semua data siswa, guru, industri untuk dropdown (tanpa filter pencarian)
        $siswas = Siswa::all();
        $gurus = Guru::all();
        $industris = Industri::all();

        return view('livewire.pkl.index', [
            'pkls' => $pkls,
            'siswas' => $siswas,
            'gurus' => $gurus,
            'industris' => $industris,
        ]);
    }

}
