<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // create user
        User::create([
            'name' => 'Tyas 01',
            'email' => 'tyas.rahma@pln.co.id',
            'password' => Hash::make('password'),
            'nomor_pegawai' => '87111357Z',
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Risky 02',
            'email' => 'risky.oktarina@pln.co.id',
            'password' => Hash::make('password'),
            'nomor_pegawai' => '8610255Z',
        ]);

        User::create([
            'name' => 'Satria 03',
            'email' => 'satria.rohman@pln.co.id',
            'password' => Hash::make('password'),
            'nomor_pegawai' => '9917127DEY',
        ]);

        User::create([
            'name' => 'Dedy 04',
            'email' => 'dedyefendy@pln.co.id',
            'password' => Hash::make('password'),
            'nomor_pegawai' => '7294035J',
        ]);
        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'nomor_pegawai' => '11111',
            'role' => 'admin',
        ]);
        User::create([
            'name' => 'User',
            'email' => 'user@gmail.com',
            'password' => Hash::make('password'),
            'nomor_pegawai' => '22222',
        ]);


    }
}
