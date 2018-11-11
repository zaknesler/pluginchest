<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Plugin::class, function (Faker $faker) {
    return [
        'name' => $name = $faker->sentence(3),
        'slug' => str_slug($name),
        'description' => $faker->sentence,
        'published_at' => now()->subDays(1),
    ];
});
