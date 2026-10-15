<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'nama' => 'Nur Baeti',
            'email' => 'Baeti@admin.com',
            'role' => '0',
            'status' => 1,
            'hp' => '085747532393',
            'password' => bcrypt('Baeti123'),
        ]);
        #untuk record berikutnya silahkan, beri nilai berbeda pada nilai: nama, email, hp dengan nilai masing-masing anggota kelompok
        User::create([
            'nama' => 'Putri Hadiyani',
            'email' => 'Putri@admin.com',
            'role' => '0',
            'status' => 1,
            'hp' => '08945328592',
            'password' => bcrypt('Putri123'),
        ]);
    }
}