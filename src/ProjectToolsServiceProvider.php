<?php

namespace Digitalion\LaravelBaseProject;

use Digitalion\LaravelBaseProject\Commands\ProjectLangCommand;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class ProjectToolsServiceProvider extends ServiceProvider
{
	/**
	 * Register services.
	 *
	 * @return void
	 */
	public function register()
	{
		$files = $this->scandir_package('config');
		foreach ($files as $file) {
			$this->mergeConfigFrom(__DIR__ . '/../config/' . $file, substr($file, -4));
		}
	}
	/**
	 * Bootstrap services.
	 *
	 * @return void
	 */
	public function boot()
	{
		if ($this->app->runningInConsole()) {

			// publish configuration files
			$files = $this->scandir_package('config');
			$files_to_publish = [];
			foreach ($files as $file) {
				if (!$this->projectFileExists(config_path(), $file)) {
					$file_in_package = __DIR__ . "/../config/{$file}";
					$file_in_project = config_path($file);
					$files_to_publish[$file_in_package] = $file_in_project;
				}
			}
			if (!empty($files_to_publish)) {
				$this->publishes($files_to_publish, 'laravel-base-project-configs');
			}


			// publish trans files
			$files = $this->scandir_package('lang');
			$files_to_publish = [];
			foreach ($files as $file) {
				if (!$this->projectFileExists(resource_path('lang/vendor/laravel-base-project/it'), $file)) {
					$file_in_package = __DIR__ . "/../lang/it/{$file}";
					$file_in_project = resource_path('lang/vendor/laravel-base-project/it/' . $file);
					$files_to_publish[$file_in_package] = $file_in_project;
				}
			}
			if (!empty($files_to_publish)) {
				$this->publishes($files_to_publish, 'laravel-base-project-langs');
			}


			// registering artisan commands
			$this->commands([
				ProjectLangCommand::class,
			]);
		}
	}

	private function scandir_package(string $dir_from_root, string $filter_extension = 'php'): array
	{
		$dir = __DIR__ . '/../' . $dir_from_root;
		$files = scandir($dir);
		$files_filtered = [];
		foreach ($files as $file) {
			$ext_len = strlen($filter_extension);
			if (strtolower(substr($file, -$ext_len)) == strtolower($filter_extension)) {
				$files_filtered[] = $file;
			}
		}
		return $files_filtered;
	}

	private function projectFileExists(string $dir, string $filename): bool
	{
		$dir = Str::finish($dir, '/');
		$dir = base_path($dir . '*.php');
		foreach (glob($dir) as $project_filename) {
			if (strpos($project_filename, $filename) !== false) return true;
		}
		return false;
	}
}
