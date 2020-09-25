<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Architect;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(App\Models\Architect::class, function (Faker $faker) {
    return [
        'source_id' => $faker->randomNumber(),
        'first_name' => $faker->firstName(),
        'last_name' => $faker->lastName(),
    ];
});
