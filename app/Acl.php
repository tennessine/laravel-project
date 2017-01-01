<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Acl extends Model {
	protected $fillable = [
		'ipaddr',
		'allow',
		'username',
		'clientID',
		'access',
		'topic',
	];

	public function getAllowStringAttribute() {
		return $this->allow ? '允许' : '阻止';
	}

	public function getAccessStringAttribute() {
		switch ($this->access) {
		case 1:
			return '订阅';
		case 2:
			return '发布';
		case 3:
			return '订阅+发布';
		default:
			return '未知';
			break;
		}
	}
}
