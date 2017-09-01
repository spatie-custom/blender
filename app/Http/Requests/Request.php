<?php

namespace App\Http\Requests;

use Route;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

abstract class Request extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param  $validator
     *
     * @return mixed
     */
    protected function failedValidation(Validator $validator)
    {
        flash()->error(trans('validation.failedForm'));

        parent::failedValidation($validator);
    }

    /**
     * Get a parameter of the current route.
     *
     * @param $key
     *
     * @return object|string
     */
    protected function getRouteParameter($key)
    {
        return Route::getCurrentRoute()->parameter($key);
    }
}
