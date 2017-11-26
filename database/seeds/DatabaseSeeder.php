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
        $this->call(UserSeeder::class);
        $this->call(PeerSeeder::class);
        $this->call(PeersUsers::class);
        $this->call(ActivitySeeder::class);
        $this->call(EventSeeder::class);
        $this->call(EventUserSeeder::class);
        $this->call(AchievmentSeeder::class);
        $this->call(MessageSeeder::class);
    }
}
