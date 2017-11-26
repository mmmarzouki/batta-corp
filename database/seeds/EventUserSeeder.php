<?php

use Illuminate\Database\Seeder;

class EventUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('events_users')->truncate();

        DB::table('events_users')->insert([
            'id_user'=>1,
            'id_event'=>1,
            'succeed'=>true
        ]);
        DB::table('events_users')->insert([
            'id_user'=>1,
            'id_event'=>2,
            'succeed'=>false
        ]);
        DB::table('events_users')->insert([
            'id_user'=>2,
            'id_event'=>2,
            'succeed'=>true
        ]);
        DB::table('events_users')->insert([
            'id_user'=>3,
            'id_event'=>3,
            'succeed'=>true
        ]);
        DB::table('events_users')->insert([
            'id_user'=>4,
            'id_event'=>4,
            'succeed'=>false
        ]);
    }
}
