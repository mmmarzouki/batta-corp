<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('users')->truncate();
        for($i=0;$i<5;$i++) {
            DB::table('users')->insert([
                'name' => str_random(10),
                'lastname' => str_random(10),
                'email' => str_random(10) . '@gmail.com',
                'password' => password_hash('0123456789',CRYPT_SHA256),
                'height' => $i/10+1.70,
                'weight' => $i+80.5,
                'age' => $i+20,
                'admin' => (($i % 2)==0),
                'access_token' => ""
            ]);
        }
    }
}
