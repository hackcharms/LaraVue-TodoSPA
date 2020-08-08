<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Todo;
use Faker\Generator as Faker;

$factory->define(Todo::class, function (Faker $faker) {
    $status=[true,false];
    return [
        'task'=>$faker->word(rand(1,3)),
        'completed'=> $status[rand(0,1)],

    ];
});
