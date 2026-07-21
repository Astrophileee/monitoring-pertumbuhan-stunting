<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \Spatie\Permission\Models\Role::create(['name' => 'Kader Posyandu']);
        \Spatie\Permission\Models\Role::create(['name' => 'Pimpinan Pustu']);
    }
}
