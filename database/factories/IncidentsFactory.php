<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Incidents;
use Faker\Generator as Faker;

$factory->define(Incidents::class, function (Faker $faker) {
    return [
        'title' => $faker->jobTitle,
        'description' => $faker->text(200),
        'value' => $faker->randomFloat(),
        'ong_id' => factory(\App\Models\Ongs::class)
    ];
});
