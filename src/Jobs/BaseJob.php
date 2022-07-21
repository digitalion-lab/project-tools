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
	protected $start_time;


	public function __construct()
	{
		$this->start_time = now();
	}

	public function handle()
	{
		$this->log();
	}

	public function failed(Throwable $exception)
	{
		$message = (!empty($exception)) ? 'Message: ' . $exception->getMessage() : '';
		$this->log($message, false);
	}

	public function log(string $message = '', bool $success = true)
	{
		$log = '[JOB ' . __CLASS__ . '] ' . ($success ? 'success' : 'failed') . "\n[data]\n";
		if (!empty($message)) $log .= "$message\n";

		$log = "\n[info]\n";
		$end_time = now();
		if (!empty($this->start_time)) {
			$log .= "Execution time: " . $this->start_time->longAbsoluteDiffForHumans($end_time, 3) . "\n";
			$log .= "Start time: " . $this->start_time->toDateTimeString() . "\n";
		}
		$log .= "End time: " . $end_time->toDateTimeString() . "\n";

		logger()->error($log);
	}
}
