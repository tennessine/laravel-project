<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagesTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('messages', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->string('from', 100)->default('')->index();
			$table->string('topic', 100)->default('');
			$table->string('payload', 100)->default('')->index();
			$table->integer('created_at')->index();
		});

		Schema::create('message_history', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->string('from', 100)->default('')->index();
			$table->string('topic', 100)->default('');
			$table->string('payload', 100)->default('')->index();
			$table->integer('created_at')->index();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('messages');
		Schema::dropIfExists('message_history');
	}
}
