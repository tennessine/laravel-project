<?php

$factory->define(App\Device::class, function (Faker\Generator $faker) {

	return [
		'user_id' => 1,
		'clientID' => $faker->macAddress,
		'username' => $faker->uuid,
		'password' => $faker->password,
		'salt' => $faker->word,
		'created_at' => $faker->dateTimeThisMonth,
		'updated_at' => $faker->dateTimeThisMonth,
	];
});

$factory->define(App\Message::class, function (Faker\Generator $faker) {

	return [
		'from' => App\Device::find(1)->clientID,
		'topic' => 'device/status',
		'payload' => 'on',
		'created_at' => time() + 3600,
	];
});