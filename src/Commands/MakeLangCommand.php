<?php

namespace Digitalion\ProjectTools\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeLangCommand extends Command
{
	protected $signature = 'make:lang {lang}';
	protected $description = 'Publishing the Laravel translation file for the chosen language.';

	/**
	 * Execute the console command.
	 *
	 * @return int
	 */
	public function handle()
	{
		$arg_lang = $this->argument('lang');

		$source = __DIR__ . '/../../locales/' . $arg_lang;
		$destination = resource_path('lang/' . $arg_lang);

		File::copyDirectory($source, $destination);
	}
}
