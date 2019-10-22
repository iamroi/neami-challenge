<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/
use Illuminate\Support\Facades\Hash;

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'password' => Hash::make('000000'),
    ];
});

$factory->define(App\Models\Product::class, function (Faker\Generator $faker) {
//    $faker->addProvider(new \Bezhanov\Faker\Provider\Commerce($faker));

    return [
        'name' => $faker->colorName,
        'description' => $faker->sentence,
        'price' => $faker->randomFloat(2, 10, 100),
    ];
});

$factory->define(App\Models\Order::class, function (Faker\Generator $faker) {
//    $users = App\User::all();
    return [
        'user_id' => App\User::find(rand(1, 10))->id, //$users->random(rand(1, 10))->pluck('id'),
        'status' => $faker->randomElement(['pending-payment', 'failed', 'processing', 'completed', 'on-hold', 'cancelled', 'refunded']),
    ];
});
