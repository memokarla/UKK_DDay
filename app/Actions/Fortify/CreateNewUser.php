<?php

namespace App\Actions\Fortify;

use App\Models\User;
use App\Models\Siswa; // ini
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException; // ini
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        // ini bawaan ya
        // ini untuk validasi data 
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],

            // pada email ini, tambahkan email di 'unique:users'
            // email yang dimasukkan harus unik dalam tabel users, kolom email
            // sintaksnya tu 'unique:[table],[field]'
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate(); // akan memeriksa apakah data yang diberikan sesuai dengan aturan yang ditentukan

        // mengecek apakah email yang dimasukkan oleh pengguna ada di tabel siswa di database
        // ini jika tanpa pentung: jika pengguna registrasi dengan menginput email yang ada di table siswa, maka...
        // karena ada pentung maka: jika pengguna registrasi dengan menginput email yang TIDAK ada di table siswa, maka...
        if (!Siswa::where('email', $input['email'])->exists()) {
                                                // ->exists() : jika ada, maka mengembalikan true, jika tidak ada, mengembalikan false
                                                // jika email tidak ditemukan di tabel siswa, 
                                                // maka ValidationException dilempar, dan pesan kesalahan akan ditampilkan untuk email
            throw ValidationException::withMessages([
                'email' => 'Email ini tidak terdaftar sebagai siswa.', // aku pesannya
            ]);
        }

        // ini juga dari sananya
        // untuk membuat user baru
        // return User::create([
        $user = User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]);

        // Tambahkan role siswa
        $user->assignRole('siswa');

        return $user;
    }
}
