<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAclRequest extends FormRequest {
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
			'ipaddr' => 'ip|required_without:username,clientID,topic',
			'allow' => 'required|in:0,1',
			'username' => 'required_without:ipaddr,clientID,topic',
			'clientID' => 'required_without:ipaddr,username,topic',
			'access' => 'required|in:1,2,3',
			'topic' => 'required_without:username,clientID,topic',
		];
	}
}
