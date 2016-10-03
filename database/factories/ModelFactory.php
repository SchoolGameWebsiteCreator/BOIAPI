<?php

$factory->define(App\Models\Item::class, function (Faker\Generator $faker) {
    return [
        'id' => str_random(5),
        'name' => $faker->md5,
    ];
});
