<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Task;
use Faker\Generator as Faker;

$factory->define(Task::class, function (Faker $faker) {
    return [
        'body' => $faker->paragraph,
        'completed_at' => \Carbon\Carbon::now(),
        'project_id' => function () {
            return factory('App\Project')->create()->id;
        }
    ];
});
