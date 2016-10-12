<?php

use App\Models\Stat;
use App\Models\Item;
use App\Models\Boss;
use App\Models\Pickup;
use App\Models\Chapter;
use App\Models\Monster;
use App\Models\Platform;
use App\Models\Character;
use App\Models\PickupType;
use App\Models\Environment;
use App\Models\Installment;
use App\Models\PillAppearance;

$factory->define(Item::class, function (Faker\Generator $faker) {
    return [
        'id' => str_random(5),
        'name' => $faker->md5,
    ];
});

$factory->define(Boss::class, function (Faker\Generator $faker) {
    return [
        'id' => str_random(5),
        'name' => $faker->md5,
    ];
});

$factory->define(Character::class, function (Faker\Generator $faker) {
    return [
        'id' => str_random(5),
        'name' => $faker->md5,
    ];
});

$factory->define(Monster::class, function (Faker\Generator $faker) {
    return [
        'id' => str_random(5),
        'name' => $faker->md5,
    ];
});

$factory->define(PickupType::class, function (Faker\Generator $faker) {
    return [
        'id' => str_random(5),
        'name' => $faker->md5,
    ];
});

$factory->define(Pickup::class, function (Faker\Generator $faker) {
    return [
        'id' => str_random(5),
        'name' => $faker->md5,
        'pickup_type_id' => factory(PickupType::class)->create()->id,
    ];
});

$factory->define(PillAppearance::class, function (Faker\Generator $faker) {
    return [
        'id' => str_random(5),
        'identifier' => $faker->slug,
    ];
});

$factory->define(Chapter::class, function (Faker\Generator $faker) {
    return [
        'id' => str_random(5),
        'name' => $faker->md5,
    ];
});

$factory->define(Environment::class, function (Faker\Generator $faker) {
    return [
        'id' => str_random(5),
        'name' => $faker->md5,
        'chapter_id' => factory(Chapter::class)->create()->id,
    ];
});

$factory->define(Installment::class, function (Faker\Generator $faker) {
    return [
        'id' => str_random(5),
        'name' => $faker->md5,
        'order' => $faker->unique()->numberBetween(1, 100),
    ];
});

$factory->define(Stat::class, function (Faker\Generator $faker) {
    return [
        'id' => str_random(5),
        'name' => $faker->md5,
        'is_hidden' => $faker->boolean,
    ];
});

$factory->define(Platform::class, function (Faker\Generator $faker) {
    return [
        'id' => str_random(5),
        'name' => $faker->md5,
    ];
});
