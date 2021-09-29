<?php

namespace Digitalion\ProjectTools;

use Digitalion\ProjectTools\Commands\MakeClassCommand;
use Digitalion\ProjectTools\Commands\MakeEnumCommand;
use Digitalion\ProjectTools\Commands\MakeHelperCommand;
use Digitalion\ProjectTools\Commands\MakeScopeCommand;
use Digitalion\ProjectTools\Commands\MakeTraitCommand;
use Illuminate\Support\ServiceProvider;

class ProjectToolsServiceProvider extends ServiceProvider
{
	/**
	 * Register services.
	 *
	 * @return void
	 */
	public function register()
	{
		//
	}

	/**
	 * Bootstrap services.
	 *
	 * @return void
	 */
	public function boot()
	{
		if ($this->app->runningInConsole()) {
			$this->commands([
				MakeClassCommand::class,
				MakeEnumCommand::class,
				MakeHelperCommand::class,
				MakeScopeCommand::class,
				MakeTraitCommand::class,
			]);
		}
	}
}
