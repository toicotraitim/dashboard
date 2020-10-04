<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
class DatabaseMenu extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('menus')->insert([
            'menu_name' => Str::random(10),
            'menu_description' => Str::random(10),
            'menu_parent' => '0',
            'menu_active' => '1',
            'menu_slug' => 'none',
        ]);
    }
}
