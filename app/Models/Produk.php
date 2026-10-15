<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    public $timestamps = true; 
    protected $table = "produk";
    
  
    protected $guarded = ['id'];
    
    
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }
    
    // Relasi 2: Produk dimiliki oleh SATU User (Admin) [cite: 924]
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    // Relasi 3: Produk memiliki BANYAK Foto Tambahan (Diperlukan untuk method show()) 
    public function fotoProduk()
    {
        // One-to-Many ke model FotoProduk
        return $this->hasMany(FotoProduk::class, 'produk_id');
    }
}