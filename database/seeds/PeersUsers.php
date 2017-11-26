<?php

use Illuminate\Database\Seeder;

class PeersUsers extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('peers_users')->truncate();
        DB::table('peers_users')->insert([
            'id_user'=>1,
            'id_peer'=>1
            ]);
        DB::table('peers_users')->insert([
            'id_user'=>1,
            'id_peer'=>2
        ]);
        DB::table('peers_users')->insert([
            'id_user'=>1,
            'id_peer'=>3
        ]);
        DB::table('peers_users')->insert([
            'id_user'=>2,
            'id_peer'=>1
        ]);
        DB::table('peers_users')->insert([
            'id_user'=>3,
            'id_peer'=>4
        ]);
        DB::table('peers_users')->insert([
            'id_user'=>4,
            'id_peer'=>5
        ]);
    }
}
