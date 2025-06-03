<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    protected $fillable = ['nama', 'nis', 'gender', 'rombel', 'alamat', 'kontak', 'email', 'foto', 'status_lapor_pkl']; 

    // relasi dengan pkl
    public function pkl()
    {
        return $this->hasMany(Pkl::class);
    }
}
