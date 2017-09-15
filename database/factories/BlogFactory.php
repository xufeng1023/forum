<?php

use Faker\Generator as Faker;

$factory->define(App\Blog::class, function (Faker $faker) {
	$title = rtrim($faker->sentence, '.');
    return [
        'title' => $title,
        'body' => $faker->paragraph
    ];
});
