<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Hash;
use App\Helpers\ImageHelper;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CustomerController extends Controller 
{ 
    /**
     * TAMPILAN BACKEND (Untuk Admin)
     */
    public function index()
    {
        // Mengambil data customer beserta relasi usernya
        $customer = Customer::with('user')->orderBy('id', 'desc')->get();
        return view('backend.v_customer.index', [
            'judul' => 'Data Customer',
            'sub'   => 'Halaman Pengelolaan Customer',
            'index' => $customer
        ]);
    }

    /**
     * TAMPILAN FRONTEND (Profil Akun Customer)
     */
    public function akun() 
    {
        $id = Auth::user()->id;
        $customer = Customer::where('user_id', $id)->first();

        // Jika data customer di tabel belum ada, buat otomatis
        if (!$customer) {
            $customer = Customer::create([
                'user_id' => $id,
                'no_hp'   => '', 
                'alamat'  => '',
                'pos'     => '',
            ]);
        }

        return view('v_customer.edit', [
            'judul' => 'Customer',
            'subJudul' => 'Akun Customer',
            'edit' => $customer
        ]);
    }

    /**
     * PROSES UPDATE PROFIL
     */
    public function updateProfil(Request $request)
    {
        $id = Auth::user()->id;
        $customer = Customer::where('user_id', $id)->firstOrFail();
        
        $request->validate([
            'nama'   => 'required|max:255',
            'no_hp'  => 'required|numeric|digits_between:10,15',
            'alamat' => 'required',
            'pos'    => 'required|numeric|digits:5', // Sesuai kolom di database
            'foto'   => 'image|mimes:jpeg,jpg,png,gif|file|max:1024',
        ]);

        $userData = ['nama' => $request->nama];

        if ($request->file('foto')) {
            if ($customer->user->foto) {
                $oldPath = public_path('storage/img-customer/') . $customer->user->foto;
                if (file_exists($oldPath)) { unlink($oldPath); }
            }
            $file = $request->file('foto');
            $fileName = date('YmdHis') . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            ImageHelper::uploadAndResize($file, 'storage/img-customer/', $fileName, 385, 400);
            $userData['foto'] = $fileName;
        }
        
        $customer->user->update($userData);
        $customer->update([
            'no_hp'  => $request->no_hp,
            'alamat' => $request->alamat,
            'pos'    => $request->pos,
        ]);

        return redirect()->route('customer.akun')->with('success', 'Profil berhasil diperbarui');
    }

    /**
     * LOGIN GOOGLE
     */
    public function redirect() 
{ 
    return Socialite::driver('google')->stateless()->redirect(); 
} 

public function callback()
{
    try {
        $socialUser = Socialite::driver('google')->stateless()->user();
    } catch (\Exception $e) {
        return redirect()->route('login')
            ->with('error', 'Login Google gagal, silakan coba lagi.');
    }

    $registeredUser = User::firstOrCreate(
        [
            'email' => $socialUser->email
        ],
        [
            'nama' => $socialUser->name,
            'password' => bcrypt('password123'),
            'role' => 2,
            'status' => 1,
        ]
    );

    // CEK CUSTOMER
    Customer::firstOrCreate(
        [
            'user_id' => $registeredUser->id
        ],
        [
            'google_id' => $socialUser->id,
            'google_token' => $socialUser->token,
            'alamat' => '',
            'no_hp' => '',
            'pos' => '',
        ]
    );

    Auth::login($registeredUser);

    request()->session()->regenerate();

    return redirect()
        ->route('beranda')
        ->with('success', 'Login Google berhasil');
}
public function logout(Request $request) 
    { 
        Auth::logout(); 
        $request->session()->invalidate(); 
        $request->session()->regenerateToken(); 
        return redirect('/')->with('success', 'Berhasil logout.'); 
    } 
}
