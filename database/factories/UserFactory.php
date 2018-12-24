<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\UserInfoDetails::class, function (Faker $faker) {
    return [
        'first_name' => $faker->name,
        'middle_name' => $faker->name,
        'last_name' => $faker->name,
        'email' => $faker->unique()->safeEmail
    ];
});

$factory->define(App\Employee::class, function (Faker $faker) {
    $userInfo = factory(App\UserInfoDetails::class)->create();
    return [
        'company_id' => 1,
        'user_info_detail_id' => $userInfo->id,
        //TODO add foreign keys for the rest
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'company_employee_id' => 'CTT-' . $faker->numberBetween(1, 1000),
        'birthdate' => '2000-10-10',
        'telephone_number' => '+381637229964',
        'mobile_number' => '+381637229964',
        'hours_per_day' => '8',
        'date_hired' => '2010-10-10',
        'date_ended' => '2020-11-11',
        'country' => 'Serbia',
        'region' => 'Vojvodina',
        'city' => 'Novi Sad',
        'zip_code' => 21000,
        'first_address_line' => $faker->streetAddress()
    ];
});
