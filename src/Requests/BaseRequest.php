<?php

namespace Digitalion\LaravelBaseProject\Requests;

use Illuminate\Contracts\Validation\Validator as IllValidator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class BaseRequest extends FormRequest
{
	protected function failedValidation(IllValidator $validator)
	{
		if ($this->ajax()) {
			$errors = $validator->errors();
			$response = response()->validationFailed($errors);

			throw new HttpResponseException($response);
		}
		return parent::failedValidation($validator);
	}

	public function onlyValidated(): array
	{
		$fields = $this->fields();
		return $this->only($fields);
	}

	public function fields(): array
	{
		$validation = $this->rules();
		return array_keys($validation);
	}

	public function attributes()
	{
		return trans('fields');
	}

	// public function validate()
	// {
	// 	return Validator::make(parent::all(), $this->rules(), $this->messages());
	// }
}
