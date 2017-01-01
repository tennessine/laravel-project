<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAclsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('acls', function (Blueprint $table) {
			$table->increments('id');
			// 0: deny, 1: allow
			$table->tinyInteger('allow');
			$table->string('ipaddr', 60);
			$table->string('username', 100);
			$table->string('clientID', 100);
			// 1: subscribe, 2: publish, 3: pubsub
			$table->tinyInteger('access');
			$table->string('topic', 100);
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('acls');
	}
}
