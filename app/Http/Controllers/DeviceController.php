<?php

namespace App\Http\Controllers;
use App\Device;
use App\Http\Requests\RemoveDeviceRequest;
use App\Http\Requests\StoreDeviceRequest;
use App\Http\Requests\UpdateDeviceRequest;
use App\Message;
use DB;
use Faker\Factory as Faker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

class DeviceController extends Controller {

	public function __construct() {
		$this->middleware('auth');
	}

	/**
	 * 设置设备默认阀值
	 * @return void
	 */
	public function threshold(Request $request) {

		if ($request->isMethod('get')) {

			$threshold = Cache::get('device.threshold');

			return view('device.threshold')->with('threshold', $threshold);

		} else if ($request->isMethod('put')) {

			$threshold = $request->input('threshold');

			$rules = [
				'threshold' => 'regex:/\d+,\d+/',
			];

			$messages = [
				'threshold.regex' => '阀值不合法',
			];

			$validator = Validator::make($request->all(), $rules, $messages);

			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator);
			}

			Cache::forever('device.threshold', $threshold);

			return redirect()->route('device.index')->with('status', '设备阀值设置成功');
		}
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		$devices = Device::where([
			'is_superuser' => 0,
			'user_id' => Auth::id(),
		])->paginate(20);

		$superUser = Device::where('is_superuser', 1)->first();
		$date = date('Y-m-d');
		return view('device.index', ['devices' => $devices, 'date' => $date, 'superUser' => json_encode($superUser)]);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		$faker = Faker::create();

		$threshold = Cache::get('device.threshold');

		if (!$threshold) {
			$threshold = '0.2,0.8';
		}

		return view('device.create', ['username' => $faker->uuid, 'password' => $faker->password, 'salt' => $faker->word, 'threshold' => $threshold]);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(StoreDeviceRequest $request) {
		$data = $request->all();
		$data['user_id'] = Auth::id();

		$device = Device::create($data);
		return redirect()->route('device.index')->with('status', '设备创建成功');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show(Device $device, $time) {

		$date = strtotime($time);
		$m = date('m', $date);
		$d = date('d', $date);
		$y = date('Y', $date);

		$begin = mktime(0, 0, 0, $m, $d, $y);
		$end = mktime(0, 0, 0, $m, $d + 1, $y) - 1;

		DB::statement('SET SESSION SQL_MODE = ""');

		$sql = sprintf("SELECT status, at, sum / SUM(t.`sum`) as `percent` FROM (SELECT m.`payload` AS status, COUNT(m.`payload`) AS sum, FROM_UNIXTIME(`m`.`created_at`, '%%H') AS at FROM `messages` AS m WHERE `created_at` BETWEEN %s AND %s AND m.`from` = ? GROUP BY `at`, `payload` & (1 << 2)) AS t GROUP BY t.`at`", $begin, $end);

		$data = DB::select($sql, [$device->clientID]);

		// 获取最大、最小时间
		$ranges = DB::select('select MIN(`created_at`) AS min, MAX(`created_at`) AS max from `messages` where `from` = ?', [$device->clientID]);

		if (count($ranges) > 0) {
			$range = $ranges[0];
			$range->min = date('Y-m-d', $range->min);
			$range->max = date('Y-m-d', $range->max);
		} else {
			$range = new StdClass();
			$range->min = '';
			$range->max = '';
		}

		// threshold
		$thresholds = explode(',', $device->threshold);

		// 获取来自这台设备的状态信息
		$payload = Message::where('from', $device->clientID)->orderBy('id', 'desc')->pluck('payload')->first();

		return view('device.show', [
			'data' => json_encode($data),
			'device' => $device,
			'time' => $time,
			'range' => $range,
			'threshold_min' => $thresholds[0],
			'threshold_max' => $thresholds[1],
			'payload' => $payload,
		]);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id) {
		$device = Device::find($id);
		return view('device.edit', ['device' => $device]);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(UpdateDeviceRequest $request, $id) {
		$device = Device::findOrFail($id);
		$affected = $device->update($request->all());
		return redirect()->route('device.index')->with('status', '设备更新成功');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(RemoveDeviceRequest $request, $id) {
		$device = Device::findOrFail($id);

		Device::destroy($device->id);

		// 删除所有消息
		Message::where('from', $device->clientID)->delete();
		// 删除历史消息
		DB::table('message_history')->where('from', $device->clientID)->delete();

		return redirect()->route('device.index')->with('status', '设备删除成功');
	}
}
