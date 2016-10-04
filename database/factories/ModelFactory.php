<?php

$factory->define(App\Models\Item::class, function (Faker\Generator $faker) {
    return [
        'id' => str_random(5),
        'name' => $faker->md5,
    ];
});

$factory->define(App\Models\Boss::class, function (Faker\Generator $faker) {
    return [
        'id' => str_random(5),
        'name' => $faker->md5,
    ];
});

$factory->define(App\Models\Character::class, function (Faker\Generator $faker) {
    return [
        'id' => str_random(5),
        'name' => $faker->md5,
    ];
});

$factory->define(App\Models\Monster::class, function (Faker\Generator $faker) {
    return [
        'id' => str_random(5),
        'name' => $faker->md5,
    ];
});
