<?php

use Faker\Generator as Faker;

$factory->define(App\TemplateMail::class, function (Faker $faker) {
    return [
        'title' =>$faker->sentence(3),
        'type' =>$faker->numberBetween(0, 9),
        'html_content' =>$faker->randomHtml(2, 3),
        'text_content' =>$faker->text(150)
    ];
});
