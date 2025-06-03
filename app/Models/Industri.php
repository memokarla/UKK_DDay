<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Industri extends Model
{
    use HasFactory;

    protected $fillable = ['nama', 'foto', 'bidang_usaha', 'alamat', 'kontak', 'email', 'website']; 

    // relasi dengan pkl
    public function pkls()
    {
        return $this->hasMany(Pkl::class);
    }
}