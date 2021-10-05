<?php

namespace Digitalion\LaravelBaseProject\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ProjectLangCommand extends Command
{
	protected $signature = 'project:lang {lang}';
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
