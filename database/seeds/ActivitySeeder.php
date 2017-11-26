<?php

use Illuminate\Database\Seeder;

class ActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('activities')->truncate();
        for($i=0;$i<5;$i++) {
            $peerInt=$i+1;
            if($i==4)
                $peerInt=1;
            DB::table('activities')->insert([
                'name' => str_random(10),
                'description' => str_random(10),
                'duration' => str_random(10),
                'id_peer' => $peerInt
            ]);
        }
    }
}
