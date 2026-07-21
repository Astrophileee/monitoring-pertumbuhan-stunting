<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kader = \App\Models\User::create([
            'name' => 'Kader Posyandu',
            'email' => 'kader@posyandu.com',
            'password' => bcrypt('password'),
        ]);
        $kader->assignRole('Kader Posyandu');

        $pimpinan = \App\Models\User::create([
            'name' => 'Pimpinan Pustu',
            'email' => 'pimpinan@posyandu.com',
            'password' => bcrypt('password'),
        ]);
        $pimpinan->assignRole('Pimpinan Pustu');
    }
}
