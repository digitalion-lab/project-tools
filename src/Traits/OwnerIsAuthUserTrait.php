<?php

namespace Digitalion\LaravelBaseProject\Traits;

use Digitalion\LaravelBaseProject\Scopes\OwnerScope;

trait OwnerIsAuthUserTrait
{
	public static function bootOwnerIsAuthUserTrait()
	{
		static::addGlobalScope(new OwnerScope);
	}
}
