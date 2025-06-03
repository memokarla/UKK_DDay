<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Industri;

class IndustriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $industri = Industri::get();
        return response()->json($industri, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $industri = new Industri(); 
        $industri->nama = $request->nama;
        $industri->foto = $request->foto;
        $industri->bidang_usaha = $request->bidang_usaha;
        $industri->alamat = $request->alamat;
        $industri->kontak = $request->kontak;
        $industri->email = $request->email;
        $industri->website = $request->website;
        $industri->save(); // menyimpan ke database
        return response()->json($industri, 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $industri = Industri::find($id);
        return response()->json($industri, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $industri = Industri::find($id);
        if (!$industri) {
            return response()->json(['message' => 'Industri Tidak Ditemukan'], 404);
        }

        $request->validate([
            'nama' => 'sometimes|required|string|max:255',
            'foto' => 'sometimes|string',
            'bidang_usaha' => 'sometimes|required|string',
            'alamat' => 'sometimes|required|string',
            'kontak' => 'sometimes|required|string',
            'email' => 'sometimes|required|email|unique:industris,email,' . $industri->id,
            'website' => 'sometimes|required|url',
        ]);

        $industri->nama = $request->nama ?? $industri->nama;
        $industri->foto = $request->foto ?? $industri->foto;
        $industri->bidang_usaha = $request->bidang_usaha ?? $industri->bidang_usaha;
        $industri->alamat = $request->alamat ?? $industri->alamat;
        $industri->kontak = $request->kontak ?? $industri->kontak;
        $industri->email = $request->email ?? $industri->email;
        $industri->website = $request->website ?? $industri->website;
        $industri->save();

        return response()->json($industri, 200); 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Industri::destroy($id); // menghapus baris dengan ID yang dimaksud
        return response()->json(["message"=>"Deleted"], 200);
    }
}
