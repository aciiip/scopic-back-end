<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Models\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'name' => $faker->text(20),
        'description' => $faker->paragraph(10),
        'price' => $faker->numberBetween(10, 100),
        'close_at' => $faker->dateTimeBetween('now', '1 month')
    ];
});
