<?php

use Illuminate\Database\Seeder;

class MessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('messages')->truncate();
        for($i=0;$i<5;$i++) {
            $typeString="text";
            $userInt=$i;
            if($i==3)
                $userInt=1;
            if($i%2==0)
                $typeString="photo";
            DB::table('messages')->insert([
                'type' => $typeString,
                'content' => str_random(10),
                'id_peer' => $i,
                'id_user' => $userInt
            ]);
        }
    }
}
