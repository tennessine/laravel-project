<?php

namespace App\Http\Controllers;

class HomeController extends Controller {
	public function __construct() {
		$this->middleware('auth');
	}

	public function index() {
		return view('home');
	}

	public function bar($attribute, $value, $parameters, $validator) {
		return $value == 'bar';
	}
}
