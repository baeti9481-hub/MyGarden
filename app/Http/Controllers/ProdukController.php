<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\ImageHelper; // Diperlukan untuk upload gambar
use App\Models\Produk;
use App\Models\Kategori;
use App\Models\FotoProduk; // Digunakan untuk manajemen foto tambahan

class ProdukController extends Controller
{
    
    public function index(Request $request)
{
    $keyword = $request->get('search');

    $index = Produk::with(['kategori', 'user'])
        ->when($keyword, function ($query) use ($keyword) {
            return $query->where('nama_produk', 'LIKE', "%$keyword%");
        })
        ->orderBy('updated_at', 'desc')
        ->paginate(25); // Mengaktifkan pembagian data per halaman
    $index->appends($request->all());
    return view('backend.v_produk.index', [
        'judul' => 'Produk',
        'index' => $index
    ]);
}
    
    public function lokasi()
    {
        // Menampilkan view lokasi yang ada di folder v_lokasi
        return view('v_lokasi.lokasi', [
            'judul' => 'Lokasi'
        ]);
    }

   public function produkFrontend(\Illuminate\Http\Request $request, $kategori = null)
{
    // 1. Ambil semua kategori untuk ditampilkan di menu dropdown
    $allKategori = \App\Models\Kategori::all();
    // 2. Gunakan Query Builder agar filter bisa ditumpuk
    $query = Produk::where('status', 1);
    // 3. Filter berdasarkan Kategori (Jika ada di URL)
    if ($kategori) {
        $query->whereHas('kategori', function($q) use ($kategori) {
            $q->where('nama_kategori', 'like', '%' . $kategori . '%');
        });
        $judul = "Kategori: " . ucfirst($kategori);
    } else {
        $judul = "Semua Produk";
    }
    // 4. Filter berdasarkan Pencarian (Search)
    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('nama_produk', 'like', '%' . $search . '%')
              ->orWhere('detail', 'like', '%' . $search . '%'); // Revisi: Menggunakan kolom 'detail'
        });
        $judul = "Hasil Pencarian: \"" . $search . "\"";
    }
    // 5. Eksekusi query dengan urutan terbaru & pagination
    // appends($request->all()) penting agar filter tidak hilang saat klik Page 2
    $produk = $query->orderBy('updated_at', 'desc')
                    ->paginate(12)
                    ->appends($request->all());

    return view('v_produk.produk', [
        
        'judul' => $judul,
        'produk' => $produk,
        'kategori' => $allKategori, 
        'kategori_aktif' => $kategori
    ]);
}
    /**
     * TAMPILAN DETAIL PRODUK (FRONTEND)
     * Menampilkan detail satu produk beserta galeri foto tambahannya.
     */
    public function detailFrontend($id)
    {
        // Mengambil produk beserta relasi kategori dan foto tambahan
        $produk = Produk::with(['kategori', 'fotoProduk'])->where('status', 1)->findOrFail($id);
        
        return view('v_produk.detail', [
            'judul' => 'Detail Produk',
            'produk' => $produk
        ]);
    }

  
    public function create()
    {
        $kategori = Kategori::orderBy('nama_kategori', 'asc')->get();
        return view('backend.v_produk.create', [
            'judul' => 'Tambah Produk',
            'kategori' => $kategori
        ]);
    }

    
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'kategori_id' => 'required',
            'nama_produk' => 'required|max:255|unique:produk',
            'detail' => 'required',
            'harga' => 'required',
            'berat' => 'required',
            'stok' => 'required',
            'foto' => 'required|image|mimes:jpeg,jpg,png,gif|file|max:1024',
        ], [
            'foto.image' => 'Format gambar gunakan file dengan ekstensi jpeg, jpg, png, atau gif.',
            'foto.max' => 'Ukuran file gambar Maksimal adalah 1024 KB.'
        ]);
        
        $validatedData['user_id'] = auth()->id();
        $validatedData['status'] = 0; 
        
        if ($request->file('foto')) {
            $file = $request->file('foto');
            $extension = $file->getClientOriginalExtension();
            $originalFileName = date('YmdHis') . '_' . uniqid() . '.' . $extension;
            $directory = 'storage/img-produk/';
            
            $fileName = ImageHelper::uploadAndResize($file, $directory, $originalFileName);
            
            ImageHelper::uploadAndResize($file, $directory, 'thumb_lg_' . $originalFileName, 800, null);
            ImageHelper::uploadAndResize($file, $directory, 'thumb_md_' . $originalFileName, 500, 519);
            ImageHelper::uploadAndResize($file, $directory, 'thumb_sm_' . $originalFileName, 100, 110);

            $validatedData['foto'] = $originalFileName;
        }
        
        Produk::create($validatedData);
        return redirect()->route('backend.produk.index')->with('success', 'Data berhasil tersimpan');
    }

    /**
     * Display the specified resource (Backend Show).
     */
    public function show(string $id)
    {
        $produk = Produk::with('fotoProduk')->findOrFail($id); 
        $kategori = Kategori::orderBy('nama_kategori', 'asc')->get();

        return view('backend.v_produk.show', [
            'judul' => 'Detail Produk',
            'show' => $produk,
            'kategori' => $kategori
        ]);
    }

   
    public function edit(string $id)
    {
        $produk = Produk::findOrFail($id);
        $kategori = Kategori::orderBy('nama_kategori', 'asc')->get();
        return view('backend.v_produk.edit', [
            'judul' => 'Ubah Produk',
            'edit' => $produk,
            'kategori' => $kategori
        ]);
    }

    public function update(Request $request, string $id)
    {
        $produk = Produk::findOrFail($id);
        $rules = [
            'nama_produk' => 'required|max:255|unique:produk,nama_produk,' . $id,
            'kategori_id' => 'required',
            'status' => 'required',
            'detail' => 'required',
            'harga' => 'required',
            'berat' => 'required',
            'stok' => 'required',
            'foto' => 'image|mimes:jpeg,jpg,png,gif|file|max:1024',
        ];
        
        $validatedData = $request->validate($rules);
        $validatedData['user_id'] = auth()->id();
        
        if ($request->file('foto')) {
            if ($produk->foto) {
                $directory = public_path('storage/img-produk/');
                $filesToDelete = [$produk->foto, 'thumb_lg_'.$produk->foto, 'thumb_md_'.$produk->foto, 'thumb_sm_'.$produk->foto];
                foreach ($filesToDelete as $file) {
                    if (file_exists($directory . $file)) unlink($directory . $file);
                }
            }
            
            $file = $request->file('foto');
            $extension = $file->getClientOriginalExtension();
            $originalFileName = date('YmdHis') . '_' . uniqid() . '.' . $extension;
            $directory = 'storage/img-produk/';
            
            ImageHelper::uploadAndResize($file, $directory, $originalFileName);
            ImageHelper::uploadAndResize($file, $directory, 'thumb_lg_'.$originalFileName, 800, null);
            ImageHelper::uploadAndResize($file, $directory, 'thumb_md_'.$originalFileName, 500, 519);
            ImageHelper::uploadAndResize($file, $directory, 'thumb_sm_'.$originalFileName, 100, 110);
            
            $validatedData['foto'] = $originalFileName;
        }
        
        $produk->update($validatedData);
        return redirect()->route('backend.produk.index')->with('success', 'Data berhasil diperbaharui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);
        $directory = public_path('storage/img-produk/');
        
        if ($produk->foto) {
            $filesToDelete = [$produk->foto, 'thumb_lg_'.$produk->foto, 'thumb_md_'.$produk->foto, 'thumb_sm_'.$produk->foto];
            foreach ($filesToDelete as $file) {
                if (file_exists($directory . $file)) unlink($directory . $file);
            }
        }

        $fotoProduks = FotoProduk::where('produk_id', $id)->get();
        foreach ($fotoProduks as $fotoProduk) {
            if (file_exists($directory . $fotoProduk->foto)) unlink($directory . $fotoProduk->foto);
            $fotoProduk->delete();
        }
        
        $produk->delete();
        return redirect()->route('backend.produk.index')->with('success', 'Data berhasil dihapus');
    }
    
    // Method untuk menyimpan foto tambahan
    public function storeFoto(Request $request)
    {
        $request->validate([
            'produk_id' => 'required|exists:produk,id',
            'foto_produk.*' => 'image|mimes:jpeg,jpg,png,gif|file|max:1024',
        ]);
        
        if ($request->hasFile('foto_produk')) {
            foreach ($request->file('foto_produk') as $file) {
                $extension = $file->getClientOriginalExtension();
                $filename = date('YmdHis') . '_' . uniqid() . '.' . $extension;
                $directory = 'storage/img-produk/';
                
                ImageHelper::uploadAndResize($file, $directory, $filename, 800, null);
                
                FotoProduk::create([
                    'produk_id' => $request->produk_id,
                    'foto' => $filename,
                ]);
            }
        }
        return redirect()->route('backend.produk.show', $request->produk_id)->with('success', 'Foto berhasil ditambahkan.');
    }

    // Method untuk menghapus foto tambahan
    public function destroyFoto($id)
    {
        $foto = FotoProduk::findOrFail($id);
        $produkId = $foto->produk_id;
        $imagePath = public_path('storage/img-produk/') . $foto->foto;
        if (file_exists($imagePath)) unlink($imagePath);
        $foto->delete();
        
        return redirect()->route('backend.produk.show', $produkId)->with('success', 'Foto berhasil dihapus.');
    }
    
    public function formProduk()
    {
        return view('backend.v_produk.form', ['judul' => 'Laporan Data Produk']);
    }
    
    public function cetakProduk(Request $request)
    {
        $request->validate([
            'tanggal_awal' => 'required|date',
            'tanggal_akhir' => 'required|date|after_or_equal:tanggal_awal',
        ]);
        
        $tanggalAwal = $request->input('tanggal_awal');
        $tanggalAkhir = $request->input('tanggal_akhir');
        
        $produk = Produk::whereBetween('updated_at', [$tanggalAwal, $tanggalAkhir])->orderBy('id', 'desc')->get();
        
        return view('backend.v_produk.cetak', [
            'judul' => 'Laporan Produk',
            'tanggalAwal' => $tanggalAwal,
            'tanggalAkhir' => $tanggalAkhir,
            'cetak' => $produk
        ]);
    }
}