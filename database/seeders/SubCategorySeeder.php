<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\SubCategory;
use Carbon\Carbon;
use DateTime;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $data = [
        //     [
        //         'name' => 'Usability 1',
        //         'category_id' => 1,
        //         'created_at' => Carbon::now(),
        //         'updated_at' => Carbon::now(),
        //     ],
        //     [
        //         'name' => 'Webuse 1',
        //         'category_id' => 2,
        //         'description' => 'webuse 1',
        //         'created_at' => Carbon::now(),
        //         'updated_at' => Carbon::now(),
        //     ],
        // ];
        // SubCategory::insert($data);
    }
}
