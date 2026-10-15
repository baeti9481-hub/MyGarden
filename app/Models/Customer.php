<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Customer extends Authenticatable 
{ 
    use HasFactory, Notifiable; 

    protected $table = 'customer'; 

    protected $fillable = [ 
        'user_id', 
        'nama', 
        'email', 
        'status', 
        'role', 
        'password', 
        'no_hp', 
        'alamat', 
        'pos', 
        'foto', 
        'google_id', 
        'google_token', 
    ]; 

    protected $hidden = [ 
        'password', 
        'remember_token', 
    ]; 

    protected $casts = [ 
        'email_verified_at' => 'datetime', 
    ];

    /**
     * Logika Otomatis saat data dihapus
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($customer) { 
            // Hapus user yang terkait ketika customer dihapus 
            if ($customer->user) { 
                $customer->user->delete(); 
            } 
        }); 
    }

    /**
     * Relasi ke Model User
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}