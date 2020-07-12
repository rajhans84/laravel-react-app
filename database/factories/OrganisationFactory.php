<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Organisation;
use Faker\Generator as Faker;

$factory->define(Organisation::class, function (Faker $faker) {
    return [
        'name' => $faker->domainWord,
        'description' => $faker->text,
    ];
});
