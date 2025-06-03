<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Siswa;

class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $siswa = Siswa::get();
        return response()->json($siswa, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $siswa = new Siswa(); 
        $siswa->nama = $request->nama;
        $siswa->nis = $request->nis;
        $siswa->gender = $request->gender;
        $siswa->rombel = $request->rombel;
        $siswa->alamat = $request->alamat;
        $siswa->kontak = $request->kontak;
        $siswa->email = $request->email;
        $siswa->foto = $request->foto;
        $siswa->status_lapor_pkl = $request->status_lapor_pkl;
        $siswa->save(); // menyimpan ke database
        return response()->json($siswa, 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $siswa = Siswa::find($id); 
        return response()->json($siswa, 200); 
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $siswa = Siswa::find($id);
        if (!$siswa) {
            return response()->json(['message' => 'Siswa Tidak Ditemukan'], 404);
        }

        $request->validate([
            'nama' => 'sometimes|required|string|max:255',
            'nis' => 'sometimes|required|numeric|unique:siswas,nis,' . $siswa->id,
            'gender' => 'sometimes|required|in:Laki-laki,Perempuan',
            'rombel' => 'sometimes|required|in:SIJA A,SIJA B',
            'alamat' => 'sometimes|required|string',
            'kontak' => 'sometimes|required|string',
            'email' => 'sometimes|required|email|unique:siswas,email,' . $siswa->id,
            'foto' => 'sometimes|nullable|image|max:2048',
            'status_lapor_pkl' => 'sometimes|required|boolean',
        ]);

        $siswa->nama = $request->nama ?? $siswa->nama;
        $siswa->nis = $request->nis ?? $siswa->nis;
        $siswa->gender = $request->gender ?? $siswa->gender;
        $siswa->rombel = $request->rombel ?? $siswa->rombel;
        $siswa->alamat = $request->alamat ?? $siswa->alamat;
        $siswa->kontak = $request->kontak ?? $siswa->kontak;
        $siswa->email = $request->email ?? $siswa->email;
        $siswa->foto = $request->foto ?? $siswa->foto;
        $siswa->status_lapor_pkl = $request->status_lapor_pkl ?? $siswa->status_lapor_pkl;
        $siswa->save();

        return response()->json($siswa, 200); 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Siswa::destroy($id); // menghapus baris dengan ID yang dimaksud
        return response()->json(["message"=>"Deleted"], 200);
    }
}
