<?php

namespace Database\Seeders;

use App\Models\Category;
use Carbon\Carbon;
use DateTime;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'name' => 'LOCAL',
                'description' => 'kategori local adalah kategori yang digunakan untuk mengelompokkan data yang bersumber dari dalam negeri',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'EXPORT',
                'description' => 'kategori export adalah kategori yang digunakan untuk mengelompokkan data yang bersumber dari luar negeri',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'X',
                'description' => 'kategori x',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];
        Category::insert($data);
    }
}
