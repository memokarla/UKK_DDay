<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pkl extends Model
{
    use HasFactory;

    protected $fillable = ['siswa_id', 'guru_id', 'industri_id', 'mulai', 'selesai']; 

    // relasi dengan guru
    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }

    // relasi dengan industri
    public function industri()
    {
        return $this->belongsTo(Industri::class);
    }

    // relasi dengan siswa
    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }
}
