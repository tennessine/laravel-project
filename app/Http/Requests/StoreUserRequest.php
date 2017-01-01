<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest {
	protected function formatErrors(Validator $validator) {
		return $validator->errors()->all();
	}

	public function messages() {
		return [
			'name.required' => '用户名必须填写',
			'email.required' => '邮箱必须填写',
			'email.unique' => '邮箱已被占用',
			'password.required' => '密码必须填写',
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
			'name' => 'required|max:255',
			'email' => 'required|email|max:255|unique:users',
			'password' => 'required|min:6',
		];
	}
}
