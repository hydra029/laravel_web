<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAttendanceShiftTimeRequest extends FormRequest
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
			'check_in_start'    => [
				'required',
				'string',
				'regex:/^([0-1]\d|2[0-3]):([0-5]\d)$/',
			],
			'check_in_end '     => [
				'required',
				'string',
				'regex:/^([0-1]\d|2[0-3]):([0-5]\d)$/',
			],
			'check_in_late_1'   => [
				'required',
				'string',
				'regex:/^([0-1]\d|2[0-3]):([0-5]\d)$/',
			],
			'check_in_late_2'   => [
				'required',
				'string',
				'regex:/^([0-1]\d|2[0-3]):([0-5]\d)$/',
			],
			'check_out_early_1' => [
				'required',
				'string',
				'regex:/^([0-1]\d|2[0-3]):([0-5]\d)$/',
			],
			'check_out_early_2' => [
				'required',
				'string',
				'regex:/^([0-1]\d|2[0-3]):([0-5]\d)$/',
			],
			'check_out_start'   => [
				'required',
				'string',
				'regex:/^([0-1]\d|2[0-3]):([0-5]\d)$/',
			],
			'check_out_end'     => [
				'required',
				'string',
				'regex:/^([0-1]\d|2[0-3]):([0-5]\d)$/',
			],

		];
	}
}
