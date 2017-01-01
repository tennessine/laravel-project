<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDeviceRequest extends FormRequest {
	public function messages() {
		return [
			'clientID.required' => '设备号必须填写',
			'username.required' => '用户名必须填写',
			'clientID.unique' => '设备号已被占用',
			'username.unique' => '用户名已被占用',
			'password.required' => '密码必须填写',
			'threshold.regex' => '设备阀值格式有误',
		];
	}
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize() {
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules() {
		return [
			'clientID' => 'required|unique:devices|max:100',
			'name' => 'max:100',
			'username' => 'required|unique:devices|max:100',
			'password' => 'required',
			'threshold' => 'regex:/\d+,\d+/',
		];
	}
}
