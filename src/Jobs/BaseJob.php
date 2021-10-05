<?php

namespace Digitalion\LaravelBaseProject\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Throwable;

class BaseJob implements ShouldQueue
{
	use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

	public $timeout = 0;

	/**
	 * Handle a job failure.
	 *
	 * @param  Throwable  $exception
	 * @return void
	 */
	public function failed(Throwable $exception)
	{
		logger()->error('[JOB ' . __CLASS__ . "] failed\n[data]\nMessage: " . (!empty($exception)) ? $exception->getMessage() : '');
	}
}
