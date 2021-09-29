<?php

namespace Digitalion\ProjectTools\Commands;

use Illuminate\Console\GeneratorCommand;

class MakeClassCommand extends GeneratorCommand
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $name = 'make:class';

	/**
	 * The type of class being generated.
	 *
	 * @var string
	 */
	protected $type = 'Class';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Create a new generic class';


	/**
	 * Get the stub file for the generator.
	 *
	 * @return string
	 */
	protected function getStub()
	{
		return __DIR__ . '/stubs/class.stub';
	}

	/**
	 * Get the default namespace for the class.
	 *
	 * @param  string  $rootNamespace
	 * @return string
	 */
	protected function getDefaultNamespace($rootNamespace)
	{
		return $rootNamespace . '\Classes';
	}
}
