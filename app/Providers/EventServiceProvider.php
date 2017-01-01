<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider {
	/**
	 * The event listener mappings for the application.
	 *
	 * @var array
	 */
	protected $listen = [
		'Illuminate\Mail\Events\MessageSending' => [
			'App\Listeners\LogSentMessage',
		],
		'Illuminate\Notifications\Events\NotificationSent' => [
			'App\Listeners\LogNotification',
		],
		'App\Events\OrderShipped' => [
			'App\Listeners\SendShipmentNotification',
		],
		'App\Events\ShippingStatusUpdated' => [

		],
	];

	/**
	 * Register any events for your application.
	 *
	 * @return void
	 */
	public function boot() {
		parent::boot();

		Broadcast::channel('test/topic', function ($user, $orderId) {
			return true;
		});
	}
}
