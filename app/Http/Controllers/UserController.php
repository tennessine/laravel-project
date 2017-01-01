<?php

namespace App\Http\Controllers;

use App\Device;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\User;

class UserController extends Controller {
	public function __construct() {
		$this->middleware('auth');
	}
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		$users = User::paginate(20);
		return view('user.index', ['users' => $users]);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		return view('user.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(StoreUserRequest $request) {
		$data = $request->all();
		$data['password'] = bcrypt($data['password']);
		$user = User::create($data);
		return redirect()->route('user.index')->with('status', '管理员创建成功');
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id) {
		$user = User::find($id);
		return view('user.edit', ['user' => $user]);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(UpdateUserRequest $request, $id) {
		$user = User::findOrFail($id);
		$data = $request->all();
		if ($data['password']) {
			$data['password'] = bcrypt($data['password']);
		}
		$user->update($data);
		return redirect()->route('user.index')->with('status', '管理员更新成功');
	}
	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id) {

		$devices = Device::where('user_id', $id)->get();
		$count = $devices->count();

		if ($count > 0) {
			return redirect()->route('user.index')->with('status', '请先删除该用户的设备');
		}

		$user = User::findOrFail($id);
		User::destroy($user->id);

		return redirect()->route('user.index')->with('status', '管理员删除成功');
	}
}
