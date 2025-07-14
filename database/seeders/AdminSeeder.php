<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin::create([
            'name'=> "Admin",
            'username' => 'admin',
            'password' => Hash::make('admin'),
            'email' => 'admin@example.com',
            'phone' => '08123456789'
        ]);
    }
}
