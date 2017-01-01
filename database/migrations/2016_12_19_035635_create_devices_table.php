<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDevicesTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('devices', function (Blueprint $table) {
			$table->increments('id');
			// 拥有设备的用户
			$table->integer('user_id')->index();
			// 用户自定义设备名称
			$table->string('name', 100);
			// 设备登陆验证
			$table->string('clientID', 100)->unique();
			$table->string('username', 100);
			$table->string('password', 100);
			// 设备阀值
			$table->string('threshold');
			//
			$table->string('salt', 20);
			// 是否为超级管理员, 超级管理员可以给其他设备发送控制指令
			$table->tinyInteger('is_superuser')->default(0);
			// 设备连接状态
			$table->tinyInteger('status')->default(0);
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('devices');
	}
}
