<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AttendanceRequest extends FormRequest
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
			'time' => [
				'required',
				'string',
				'regex:/^([0-1]\d|2[0-3]):([0-5]\d)$/',
			],
		];
	}

	public function messages(): array
	{
		return [
			'time.regex' => session()->flash('noti', [
				'heading' => 'What do you want ???',
				'text'    => 'You are trying to break my app ???',
				'icon'    => 'success',
			]),
		];
	}
}
