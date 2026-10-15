<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;
    
    // 🛑 Wajib ditambahkan agar kolom updated_at tidak dicari di database
    public $timestamps = false; 

    protected $table = 'kategori'; 

    protected $fillable = [
        'nama_kategori',
    ];
    
    // ... (relasi produk opsional)
}