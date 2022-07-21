<?php

namespace Digitalion\LaravelBaseProject;

use Digitalion\LaravelBaseProject\Commands\ProjectLangCommand;
use Illuminate\Support\ServiceProvider;

class LaravelBaseProjectServiceProvider extends ServiceProvider
{
	public function register()
	{
	}

	public function boot()
	{
		if ($this->app->runningInConsole()) {
			// registering artisan commands
			$this->commands([
				LangPublishCommand::class,
			]);
		}
	}
}
