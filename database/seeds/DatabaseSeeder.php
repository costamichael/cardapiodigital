<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'wmaster',
            'email' => 'wmastermore@gmail.com',
            'password' => bcrypt('0c4l4ngo0'),
        ]);
    }
}
