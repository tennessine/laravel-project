<?php

namespace App\Listeners;

use App\Events\ShippingStatusUpdated;

class SendShipmentStatusNotification {
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
	 * @param  ShippingStatusUpdated  $event
	 * @return void
	 */
	public function handle(ShippingStatusUpdated $event) {
		file_put_contents('/Users/apple/Desktop/broadcast.log', 'ShippingStatusUpdated');
	}
}
