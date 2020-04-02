<?php

/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(Brackets\AdminAuth\Models\AdminUser::class, function (Faker\Generator $faker) {
    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'email' => $faker->email,
        'password' => bcrypt($faker->password),
        'remember_token' => null,
        'activated' => true,
        'forbidden' => $faker->boolean(),
        'language' => 'en',
        'deleted_at' => null,
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        
    ];
});/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Architect::class, static function (Faker\Generator $faker) {
    return [
        'source_id' => $faker->randomNumber(5),
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'birth_date' => $faker->date(),
        'birth_place' => $faker->sentence,
        'death_date' => $faker->date(),
        'death_place' => $faker->sentence,
        'bio' => $faker->text(),
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        
        
    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Building::class, static function (Faker\Generator $faker) {
    return [
        'source_id' => $faker->randomNumber(5),
        'title' => $faker->sentence,
        'title_alternatives' => $faker->sentence,
        'description' => $faker->text(),
        'processed_date' => $faker->date(),
        'architect_names' => $faker->sentence,
        'builder' => $faker->sentence,
        'builder_authority' => $faker->sentence,
        'location_city' => $faker->sentence,
        'location_district' => $faker->sentence,
        'location_street' => $faker->sentence,
        'location_gps' => $faker->sentence,
        'project_start_dates' => $faker->sentence,
        'project_duration_dates' => $faker->sentence,
        'decade' => $faker->randomNumber(5),
        'style' => $faker->sentence,
        'status' => $faker->sentence,
        'image_filename' => $faker->sentence,
        'bibliography' => $faker->text(),
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        
        
    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Image::class, static function (Faker\Generator $faker) {
    return [
        'source_id' => $faker->randomNumber(5),
        'building_id' => $faker->sentence,
        'title' => $faker->sentence,
        'author' => $faker->sentence,
        'created_date' => $faker->sentence,
        'source' => $faker->sentence,
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        
        
    ];
});
