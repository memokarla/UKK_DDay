<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    use HasFactory;

    protected $fillable = ['nama', 'nip', 'gender', 'alamat', 'kontak', 'email']; 

    // realasi dengan pkl
    public function pkls()
    {
        return $this->hasMany(Pkl::class);
    }
}
