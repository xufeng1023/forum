<?php

use Faker\Generator as Faker;

$factory->define(App\Post::class, function (Faker $faker) {
	$title = rtrim($faker->sentence, '.');
    return [
        'title' => $title,
        'slug' => str_slug($title),
        'body' => $faker->paragraph
    ];
});
