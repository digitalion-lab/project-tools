<?php

namespace Digitalion\LaravelBaseProject\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BaseMail extends Mailable implements ShouldQueue
{
	use Queueable, SerializesModels, MailSenderTrait;

	/**
	 * Create a new message instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		//
	}

	protected function sender(string $to_email, string $to_name = '')
	{
		if (empty($to_name)) {
			$to_name = substr($to_email, 0, strpos($to_email, '@'));
			$to_name = str_replace('.', ' ', $to_name);
			$to_name = ucwords($to_name);
		}
		$text_blade = $this->markdown . '_plain';
		$this->text = (view()->exists($text_blade)) ? $text_blade : '';

		return $this
			->to($to_email, $to_name)
			->text($this->text);
	}
}
