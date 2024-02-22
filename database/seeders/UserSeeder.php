<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $set = User::select('id')->get();
        if(count($set) == 0){ 
            $user = User::create([
                'first_name' => 'Noah',
                'last_name' => 'Import',
                'username' => 'noahimport',
                'email' => 'user@noah.com',
                'password' => Hash::make(123456), 
                'customer_no' => 'CN-001',  
                'status' => 1,
                'gender' => 1,
                'lang' => 'english',
                'theme' => 2,
                'role' => 4,
                'ref_no' => 123,
                'invite_no' => 123,
            ]);
        }
    }
}
