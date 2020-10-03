<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseCategoryProduct extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('category_product')->insert([
            'category_name' => Str::random(10),
            'category_description' => Str::random(10),
            'category_parent' => '39',
            'category_active' => '1',
        ]);
    }
}
