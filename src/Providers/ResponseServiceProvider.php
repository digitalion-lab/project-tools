<?php

namespace Digitalion\LaravelBaseProject\Providers;

use Illuminate\Support\ServiceProvider;
use Response;

class ResponseServiceProvider extends ServiceProvider
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
		$provider = $this;

		Response::macro('error', function ($errors, int $code = 404, string $message = '') use ($provider) {
			if (is_string($errors) && empty($message)) {
				$message = $errors;
				$errors = '';
			}
			if (empty($message)) $message = trans('errors.' . $code);
			if (!empty($errors)) $errors = $provider->checkResource($errors);

			$data = compact('errors', 'code', 'message');
			return $provider->apiResponse($data);
		});

		Response::macro('success', function ($data = [], int $code = 200, string $message = '')  use ($provider) {
			if ($data instanceof \Illuminate\Pagination\LengthAwarePaginator) {
				$items = collect($data->items());
				$data = $data->toArray();
				$data['data'] = $provider->checkCollection($items);
			} else {
				$data = $provider->checkCollection($data);
			}

			if (is_array($data) && !empty($data)) {
				foreach ($data as $key => $value) {
					$data[$key] = $provider->checkResource($value);
				}
			} else {
				$data = $provider->checkResource($data);
			}
			$count = is_array($data) ? count($data) : 1;
			if (!empty($data['data'])) $count = count($data['data']);

			$data = compact('data', 'code', 'message', 'count');
			return $provider->apiResponse($data);
		});
	}

	public function apiResponse(array $data)
	{
		$headers = config('laravel-base-project.api.headers');
		$code = $data['code'];
		$in_error = boolval($code >= 300 && $code < 1000);
		$json = array_merge(
			$data,
			[
				'success'	=> !$in_error,
				'status'	=> ($in_error ? 'error' : 'success'),
			]
		);

		return response()->json($json, $code, $headers, JSON_UNESCAPED_UNICODE);
	}

	public function checkCollection($data)
	{
		if ($data instanceof \Illuminate\Database\Eloquent\Collection || $data instanceof \Illuminate\Support\Collection) {
			$item = $data->first();
			if ($item instanceof \Illuminate\Database\Eloquent\Model) {
				$model_name = preg_replace('/^.+\\\\/', '', get_class($item));
				$resource_classname = '\\App\\Http\\Resources\\' . $model_name . 'Resource';
				if (class_exists($resource_classname)) $data = $resource_classname::collection($data);
			}
		}

		return $data;
	}

	public function checkResource($data)
	{
		if ($data instanceof \Illuminate\Database\Eloquent\Model) {
			$model_name = preg_replace('/^.+\\\\/', '', get_class($data));
			$resource_classname = '\\App\\Http\\Resources\\' . $model_name . 'Resource';
			if (class_exists($resource_classname)) $data = new $resource_classname($data);
		} elseif (is_array($data) && !empty($data)) {
			foreach ($data as $key => $value) {
				$data[$key] = $this->checkResource($value);
			}
		}
		return $data;
	}
}
