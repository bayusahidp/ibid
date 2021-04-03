<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call('UsersTableSeeder');
        DB::table('user')->insert([
            'name' => 'test',
            'email' => 'test@gmail.com',
            'password' => app('hash')->make('12345678')
            ]);
    }
}
