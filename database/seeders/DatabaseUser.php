<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseUser extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('users')->insert([
            'name' =>  "Vũ Bá Hướng",
            'username' => Str::random(10),
            'email' => 'vbh1996xxx@gmail.com',
            'password' => Hash::make('@admADM1996'),
        ]);
    }
}
