<?php

use Illuminate\Database\Seeder;

class MessageTableSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		// App\Message::truncate();

		factory(App\Message::class)->create([
			'payload' => 'on',
		]);
	}
}
