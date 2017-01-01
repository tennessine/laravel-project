<?php

use Illuminate\Database\Seeder;

class DeviceTableSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {

		App\Device::truncate();

		factory(App\Device::class)->create([
			'name' => 'admin',
			'clientID' => 'admin',
			'username' => 'admin',
			'threshold' => '0.2,0.8',
			'is_superuser' => 1,
		]);
	}
}
