<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Device extends Model {
	protected $fillable = [
		'user_id',
		'name',
		'clientID',
		'username',
		'password',
		'threshold',
		'salt',
	];

	protected $hidden = [

	];
}
