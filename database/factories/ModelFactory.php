<?php

use App\Models\PickupType;

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

$factory->define(App\Models\PickupType::class, function (Faker\Generator $faker) {
    return [
        'id' => str_random(5),
        'name' => $faker->md5,
    ];
});

$factory->define(App\Models\Pickup::class, function (Faker\Generator $faker) {
    return [
        'id' => str_random(5),
        'name' => $faker->md5,
        'pickup_type_id' => factory(PickupType::class)->create()->id,
    ];
});

$factory->define(App\Models\PillAppearance::class, function (Faker\Generator $faker) {
    return [
        'id' => str_random(5),
        'identifier' => $faker->slug,
    ];
});
