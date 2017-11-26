<?php

use Illuminate\Database\Seeder;

class PeerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('peers')->truncate();
        for($i=0;$i<5;$i++) {
            DB::table('peers')->insert([
                'name' => str_random(10),
                'goal' => str_random(10),
                'deadline' => str_random(10),
                'level' => str_random(10),
                'type' => str_random(10),
                'icon' => str_random(10),
            ]);
        }
    }
}
