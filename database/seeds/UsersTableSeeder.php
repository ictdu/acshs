<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'user_type' => '1',
            'name' => str_random(10),
            'email' => 'admin@spcfpartners.com',
            'password' => bcrypt('admin1234'),
        ]);
    }
}
