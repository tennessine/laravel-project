<?php

namespace App\Notifications;

use App\Channels\VoiceChannel;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\NexmoMessage;
use Illuminate\Notifications\Notification;

class InvoicePaid extends Notification {

	/**
	 * Create a new notification instance.
	 *
	 * @return void
	 */
	public function __construct() {
		//
	}

	/**
	 * Get the notification's delivery channels.
	 *
	 * @param  mixed  $notifiable
	 * @return array
	 */
	public function via($notifiable) {
		return [VoiceChannel::class];
	}

	/**
	 * Get the mail representation of the notification.
	 *
	 * @param  mixed  $notifiable
	 * @return \Illuminate\Notifications\Messages\MailMessage
	 */
	public function toMail($notifiable) {
		return (new MailMessage)
			->subject('Notification Subject')
			->line('The introduction to the notification.')
			->action('Notification Action', 'https://laravel.com')
			->line('Thank you for using our application!');
	}

	/**
	 * Get the Nexmo / SMS representation of the notification.
	 *
	 * @param  mixed  $notifiable
	 * @return NexmoMessage
	 */
	public function toNexmo($notifiable) {
		return (new NexmoMessage)
			->content('Your SMS message content');
	}

	/**
	 * Get the array representation of the notification.
	 *
	 * @param  mixed  $notifiable
	 * @return array
	 */
	public function toBroadcast($notifiable) {
		return [
			'name' => 'Musikar',
		];
	}

	/**
	 * Get the voice representation of the notification.
	 *
	 * @param  mixed  $notifiable
	 * @return VoiceMessage
	 */
	public function toVoice($notifiable) {
		return [
			'name' => 'Musikar',
		];
	}
}
