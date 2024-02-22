<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = Admin::get();
        if(count($admin) == 0){
            Admin::create([  
                'first_name' => 'Site',
                'last_name' => 'Admin',
                'username' => 'admin',
                'email' => 'admin@noah.com',
                'password' => Hash::make(123456), 
                'status' => 1,
                'gender' => 1,
                'theme' => 1,
                'timezone' => 0,
            ]);
        }
     
    }
}
