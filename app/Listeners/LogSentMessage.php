<?php

namespace App\Listeners;

use Illuminate\Mail\Events\MessageSending;

class LogSentMessage {
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
	 * @param  MessageSending  $event
	 * @return void
	 */
	public function handle(MessageSending $event) {
		file_put_contents('/Users/apple/Desktop/sent.txt', $event->channel);
	}
}
