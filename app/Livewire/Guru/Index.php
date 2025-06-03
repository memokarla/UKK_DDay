<?php

namespace App\Livewire\Guru;

use Livewire\Component;
use App\Models\Guru;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    // agar saat search tidak reload halaman, stay di halaman itu
    protected $updatesQueryString = ['search', 'selected_gender', 'selected_abjad'];
    protected $paginationTheme = 'tailwind';

    // apa public-public ini?
    // karena ini adalah Livewire component, dan agar property bisa di-bind ke form di Blade (dengan wire:model), properti harus public
    public $search = ''; // ini nama property, yang akan dipanggil di blade dengan wire:model.live
    public $selected_gender = [];
    public $selected_abjad = [];

    public function render()
    {
        // sekadar menerjemahkan enum field gender dengan variable genders
        $genders = [
            'L' => 'Laki-Laki',
            'P' => 'Perempuan',
        ];

        // sebelumnya aku mengunaka Guru:all(), namun tidak bekerja untuk serach, mengapa?
        // karena ingin menambahkan kondisi searcg/filter/sort, maka pakai Guru::query() supaya bisa bangun query step-by-step sebelum dieksekusi (seperti where)
        $gurus = Guru::query();

        if (!empty($this->search)) {
            $gurus->where(function ($query) {
                $query->where('nama', 'like', '%' . $this->search . '%')
                    ->orWhere('nip', 'like', '%' . $this->search . '%')
                    ->orWhere('alamat', 'like', '%' . $this->search . '%')
                    ->orWhere('kontak', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%');
            });
        }

        // gender
        // baca perlahan, jika user memilih gender tertentu sesuai opsi yang diberikan, akan terfilter data guru berdasarkan gender tersebut
        if ($this->selected_gender) {
            $gurus->whereIn('gender', $this->selected_gender);
        }

        // abjad
        if ($this->selected_abjad) {
            if ($this->selected_abjad === 'Abjad:A - Z') { 
                $gurus->orderBy('nama', 'asc'); // ascending, dari kecil ke besar → A ke Z, 1 ke 100
            } elseif ($this->selected_abjad === 'Abjad:Z - A') {
                $gurus->orderBy('nama', 'desc'); // descending,	dari besar ke kecil → Z ke A, 100 ke 1
            }
        }
         
        return view('livewire.guru.index', [
            'gurus' => $gurus->paginate(5),
            'genders' => $genders,
        ]);
    }
}
