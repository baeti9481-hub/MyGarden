<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;

class KategoriController extends Controller
{
    public function index()
    {
        $kategori = Kategori::orderBy('nama_kategori', 'asc')->get();

        return view('backend.v_kategori.index', [
            'judul' => 'Kategori',
            'sub'   => 'Halaman Kategori',
            'index' => $kategori
        ]);
    }

    public function create()
    {
        return view('backend.v_kategori.create', [
            'judul' => 'Tambah Kategori'
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|unique:kategori,nama_kategori'
        ], [
            'nama_kategori.required' => 'Nama kategori wajib diisi',
            'nama_kategori.unique'   => 'Nama kategori sudah ada'
        ]);

        Kategori::create([
            'nama_kategori' => $request->nama_kategori
        ]);

        return redirect()
            ->route('backend.kategori.index')
            ->with('success', 'Kategori berhasil ditambahkan');
    }

    public function edit($id)
    {
        $kategori = Kategori::findOrFail($id);

        return view('backend.v_kategori.edit', [
            'judul'   => 'Edit Kategori',
            'kategori'=> $kategori
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kategori' => 'required'
        ]);

        Kategori::where('id', $id)->update([
            'nama_kategori' => $request->nama_kategori
        ]);

        return redirect()
            ->route('backend.kategori.index')
            ->with('success', 'Kategori berhasil diupdate');
    }

    public function destroy($id)
    {
        Kategori::where('id', $id)->delete();

        return redirect()
            ->route('backend.kategori.index')
            ->with('success', 'Kategori berhasil dihapus');
    }
}
