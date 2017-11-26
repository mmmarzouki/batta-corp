<?php

use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('events')->truncate();
        for($i=0;$i<5;$i++) {
            DB::table('events')->insert([
                'month' => str_random(10),
                'level' => str_random(10),
                'name' => str_random(10)
            ]);
        }
    }
}
