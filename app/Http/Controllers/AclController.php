<?php

namespace App\Http\Controllers;

use App\Acl;
use App\Http\Requests\StoreAclRequest;
use Illuminate\Http\Request;

class AclController extends Controller {
	public function __construct() {
		$this->middleware('auth');
	}
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		$acls = Acl::paginate(20);
		return view('acl.index', ['acls' => $acls]);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		return view('acl.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(StoreAclRequest $request) {
		Acl::create($request->all());
		return redirect()->route('acl.index')->with('status', '权限设备添加成功');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id) {

	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id) {
		$acl = Acl::findOrFail($id);
		return view('acl.edit', ['acl' => $acl]);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(StoreAclRequest $request, $id) {
		$acl = Acl::findOrFail($id);
		$acl->update($request->all());
		return redirect()->route('acl.index')->with('status', '设备权限更新成功');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id) {
		Acl::destroy($id);
		return redirect()->route('acl.index')->with('status', '设备权限删除成功');
	}
}
