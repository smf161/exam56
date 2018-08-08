<?php

use Faker\Generator as Faker;

$factory->define(App\Topic::class, function (Faker $faker) {

    $items = [1, 2, 3, 4];
    shuffle($items); //隨機排列陣列

    $random_date = $faker->dateTimeBetween('-3 days', '+3 days');
    $num1        = rand(1, 99);
    $num2        = rand(1, 99);

    return [
        'topic'            => "$num1 + $num2 = ?",
        'opt' . $items[0]  => $num1 * $num2,
        'opt' . $items[1]  => $num1 + $num2,
        'opt' . $items[2]  => $num1 . $num2,
        'opt' . $items[03] => $num2 . $num1,
        'ans'              => $items[1],
        'created_at'       => $random_date,
        'updated_at'       => $random_date,
    ];
});
