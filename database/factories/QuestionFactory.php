<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Question;
use Faker\Generator as Faker;

$factory->define(\App\Question::class, function (Faker $faker) {
    return [
        'title' => rtrim($faker->sentence(rand(5, 10)), '.'),
        'body' =>$faker->paragraph(rand(3,7), true),
        'views_count'=>rand(0,10),//Eloquent Event Handling retrieved, createing, created, updating, updated,saving, saved, deleting, deleted,restoring, restored
        'votes_count' => rand(-10,10)
    ];
    //to use eloquet event we need to register the event in model ie answer model here for answers count
});
