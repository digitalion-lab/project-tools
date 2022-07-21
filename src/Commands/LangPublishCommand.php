<?php

namespace Digitalion\LaravelBaseProject\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class LangPublishCommand extends Command
{
	protected $signature = 'lang:publish {lang}';
	protected $description = 'Publishing the Laravel translation file for the chosen language.';

	public function handle()
	{
		$versions = explode('.', app()->version());
		$major_version = intval($versions[0]);

		$lang = strtolower($this->argument('lang'));
		$abs_source = __DIR__ . '/../../lang/' . $lang;
		$abs_destination = ($major_version > 9) ? lang_path($lang) : resource_path('lang/' . $lang);

		if (!File::exists($abs_source)) {
			$this->error(strtoupper($lang) . ' language is not configured in the package');
		} else {
			$copy = true;
			if (File::exists($abs_destination)) {
				$copy = $this->confirm('The language file already exists. Do you want to overwrite it?');
			}
			if ($copy) {
				if (File::copyDirectory($abs_source, $abs_destination)) {
					$this->info('The language file has been published.');
				} else {
					$this->error('The language file could not be published.');
				}
			} else {
				$this->error('Command abort.');
			}
		}
	}
}
