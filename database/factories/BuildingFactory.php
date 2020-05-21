<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Building;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(App\Models\Building::class, function (Faker $faker) {
	
	$from_year = $faker->numberBetween(1920,1980);
	$to_year = $from_year + $faker->numberBetween(1,4);

	$architect_names_length = $faker->numberBetween(1,4);
	$architect_names = [];

	for ($i=0; $i < $architect_names_length; $i++) { 
		$architect_names[] = $faker->name;
	}

    return [
        'title' => Str::title($faker->words($nb = $faker->numberBetween(2,8), $asText = true)),
        'description' => $faker->text($faker->numberBetween(300,500)),
        'architect_names' => $architect_names,
        'location_city' => $faker->city,
        'location_street' => $faker->streetAddress,
        'project_duration_dates' => "$from_year - $to_year",
    ];
});
