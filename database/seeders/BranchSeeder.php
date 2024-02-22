<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Branch;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $branchesArr = [
            ['name' => 'USA'],
            ['name' => 'Miami'],
            ['name' => 'SDM'],
        ];

        $count = Branch::count();
        if($count == 0){
            foreach($branchesArr as $arr){
                $branch = Branch::create($arr);
            }
        }

    }
}
