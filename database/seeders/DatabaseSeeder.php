<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('category_product')->insert([
            'category_name' => Str::random(10),
            'category_description' => Str::random(10),
            'category_parrent' => '0',
            'category_active' => '1',
        ]);
    }
}
