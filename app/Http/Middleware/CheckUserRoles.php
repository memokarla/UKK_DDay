<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // mengimpor facade Auth yang digunakan untuk mengakses informasi pengguna yang sedang login
use Symfony\Component\HttpFoundation\Response;

class CheckUserRoles
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response 
    {
        // ini bukan komen kang. lebih dari itu
        // ini namanya dockblock, biasanya tu /** ... */
        // biasanya untuk memberitahu IDE (Integrated Development Environment) mengenai tipe data yang digunakan
        // IDE ini software untuk ngembangin software, jadi kayak VS Code ini sendiri, lalu Arduino IDE
        // dockblock dalam konteks ini ialah
            // @var : tag ini memberi tahu IDE bahwa variabel $user adalah objek dari User (model)
            // $user : ini nama variablenya, jadi bebas
        /** @var \App\Models\User $user */

        // mengambil data pengguna yang sedang login melalui Auth::user() dan menyimpannya dalam variabel $user
        // ::user() ini memang sintaksnya, jadi jangan diganti
        $user = Auth::user();

        // bahas satu-satu
            // !Auth::check() 
                // kan di kode atas sudah dibuatkan variable untuk menyimpan kondisi pengecekan user sudah login atau belum
                // jika user sudah login, hasilnya true
                // jika user belum login, hasilnya false
                // dalam konteks ini kita menggunakan pentung di depan, yang berarti NOT
                    // maka: Jika user belum login ...
            // mengapa menggunakan operator || (atau)
                // kan diketahui satu true, maka true
                // maka, jika salah satu kondisi bernilai true, if ini akan dijalankan
                    // maka: ... atau ...
            // !$user->hasAnyRole(['super_admin', 'siswa'])
                // apakah user yang login memiliki salah satu dari atau keduanya dari role tersebut
                // jika ingin hanya 1 role, bisa tetap hasAnyRole atau seadar hasRole
                // jika memiliki satu atau keduanya role maka true
                // jika tidak memiliki satu atau keduanya role maka false
                // ada pentung juga kan, maka NOT
                    // maka: ... Jika user tidak memiliki salah satu atau kedua role
        // jika user belum login ATAU jika user tidak memiliki salah satu role atau kedua role
        if (!Auth::check() || !$user->hasAnyRole(['super_admin', 'siswa'])) {
            // maka jalankan perintah ini
            // abort(403, 'Anda belum punya akses. Silakan hubungi admin :)');
            return redirect()->route('menungguAdmin');
        }
        
        return $next($request);
    }
}
