<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => "Super Admin",
            'email' => 'super-admin@v-ticket.com',
            'contact' => '07000000000',
            'role' => 'super-admin',
            'password' => Hash::make('Admin-Vticket@2024'),
        ]);
    }
}
