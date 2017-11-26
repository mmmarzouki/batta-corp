<?php

use Illuminate\Database\Seeder;

class AchievmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('achievements')->truncate();
        for($i=0;$i<5;$i++) {
            $eventInt=$i+1;
            if($i==5)
                $eventInt=2;
            DB::table('achievements')->insert([
                'name' => str_random(10),
                'level' => str_random(10),
                'id_event' => $eventInt
            ]);
        }
    }
}
