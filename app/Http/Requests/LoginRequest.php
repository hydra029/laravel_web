<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize(): bool
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules(): array
	{
		return [
			'email'    => [
				'required',
				'string',
				'email',
			],
			'password' => [
				'required',
				'string',
				'min:8',
				'max:255',
			],
		];
	}

	public function messages(): array
	{
		return [
			'password' => session()->flash('noti', [
				'heading' => 'Your password format is incorrect !',
				'text'    => 'Password is between 8 and 255 characters long.',
				'icon'    => 'error',
			]),
		];
	}
}
