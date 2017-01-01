<?php

namespace App\Listeners;

use Illuminate\Notifications\Events\NotificationSent;

class LogNotification {
	/**
	 * Create the event listener.
	 *
	 * @return void
	 */
	public function __construct() {
		//
	}

	/**
	 * Handle the event.
	 *
	 * @param  NotificationSent  $event
	 * @return void
	 */
	public function handle(NotificationSent $event) {
		file_put_contents('/Users/apple/Desktop/notification.txt', $event->channel);
	}
}
