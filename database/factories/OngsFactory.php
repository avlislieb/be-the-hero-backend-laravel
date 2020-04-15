<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Ongs;
use Faker\Generator as Faker;

$factory->define(Ongs::class,  function (Faker $faker) {
    return [
        'id' => strval(substr(uniqid('', true), 15)),
        'name' => $name =   $faker->company ,
        'email' => $email  = $faker->companyEmail,
        'whatsapp' => $wpp =  $faker->e164PhoneNumber,
        'city' => $city =  $faker->city,
        'uf' => $uf = $faker->stateAbbr
    ];
});
