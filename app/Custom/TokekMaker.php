<?php

namespace App\Custom;



class TokenMaker
{
    public static function generate_token() {

        $faker = \Faker\Factory::create();

        $n = $faker->numberBetween(20,30);

        $token = '';

        for($i = 0; $i < $n; $i++) {
            
            $test = numberBetween(1,4);

            $token += $faker->randomAscii();
        }

        return $token;
    }
}
