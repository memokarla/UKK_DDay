<?php

namespace App\Livewire\Siswa;

use Livewire\Component;
use App\Models\Siswa;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    protected $updatesQueryString = ['search', 'selected_gender', 'selected_rombel', 'selected_abjad'];
    protected $paginationTheme = 'tailwind';

    public $search = '';
    public $selected_gender = [];
    public $selected_rombel = [];
    public $selected_abjad = [];

    public function render()
    {
        $genders = [
            'L' => 'Laki-Laki',
            'P' => 'Perempuan',
        ];

        $rombels = [
            'SijaA' => 'SIJA A',
            'SijaB' => 'SIJA B',
        ];

        $siswas = Siswa::query();

        if (!empty($this->search)) {
            $siswas->where(function ($query) {
                $query->where('nama', 'like', '%' . $this->search . '%')
                    ->orWhere('nis', 'like', '%' . $this->search . '%')
                    ->orWhere('alamat', 'like', '%' . $this->search . '%')
                    ->orWhere('kontak', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%');
            });
        }

        // gender
        if ($this->selected_gender) {
            $siswas->whereIn('gender', $this->selected_gender);
        }

        // rombel
        if ($this->selected_rombel) {
            $siswas->whereIn('rombel', $this->selected_rombel);
        }

        // abjad
        if ($this->selected_abjad) {
            if ($this->selected_abjad === 'Abjad:A - Z') { 
                $siswas->orderBy('nama', 'asc'); // ascending, dari kecil ke besar → A ke Z, 1 ke 100
            } elseif ($this->selected_abjad === 'Abjad:Z - A') {
                $siswas->orderBy('nama', 'desc'); // descending,	dari besar ke kecil → Z ke A, 100 ke 1
            }
        }

        return view('livewire.siswa.index', [
            'siswas' => $siswas->paginate(10), 
            'genders' => $genders,
            'rombels' => $rombels,
        ]);
    }
}
