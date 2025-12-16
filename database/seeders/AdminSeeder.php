<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Shared\Admin;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        Admin::create([
            'emailAdmin' => 'superadmin@helpora.com',
            'passwordAdmin' => Hash::make('super123'),
        ]);
    }
}