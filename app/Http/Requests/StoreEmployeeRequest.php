<?php

namespace App\Http\Requests;

use App\Models\Department;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class StoreEmployeeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return session('level') === 4;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'fname' => [
                'required',
                'string',
                'max:10',
                'min:2',
            ],
            'lname' => [
                'required',
                'string',
                'max:10',
                'min:2' ,
            ],
            'gender' => [
                'required',
                'boolean',
            ],
            'dob' => [
                'required',
                'date',
                'before:15 years ago',
            ],
            'avatar' => [
                'image',
                'mimes:jpeg,png',
                'max:2048',
            ],
            'city' => [
                'required',
                'string',
                'min:2',
                'max:2048',
            ],
            'district' => [
                'required',
                'string',
                'min:2',
                'max:2048',
            ],
            'phone' => [
                'required',
                'string',
                'min:10',
                'max:10',
                'regex:/(0)[0-9]{9}/',
                'unique:App\Models\Employee,phone',
            ],
            'email' => [
                'required' ,
                'email:rfc,dns',
                'min:10',
                'max:50',
                'unique:App\Models\Employee,email',
            ],
            'password' => [
                'required',
                'string',
                Password::min(6)
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->uncompromised(),
            ],
            'dept_id' => [
                'required' ,
                'integer' ,
            ],
            'role_id' => [
                'required' ,
                'integer' ,
            ],

        ];
    }

    public function messages(): array
    {
        return [
            'fname' => [
                'required' => 'We need to know  :attribute ',
                'max:10' => ' :attribute  must be at least 10 characters',
                'min:2' => ' :attribute  must have at least 2 characters',
            ],
            'lname' => [
                'required' => 'We need to know  :attribute ',
                'max:10' => ' :attribute  must be at least 10 characters',
                'min:2' => ' :attribute  must have at least 2 characters',
            ],
            'gender' => [
                'required' => 'We need to know  :attribute ',
            ],
            'dob' => [
                'required' => 'We need to know :attribute ',
                'before:15 years ago' => 'it is not old enough to work.',
            ],
            'avatar' => [
                'image',
                'mimes:jpeg,png' => 'Incorrect file format',
                'max:2048' => ':attribute too long',
            ],
            'city' => [
                'required' => 'We need to know  :attribute ',
                'min:10' => ' :attribute too long',
                'max:200' => ':attribute too short',
            ],
            'district' => [
                'required' => 'We need to know  :attribute ',
                'min:10' => ' :attribute too long',
                'max:200' => ':attribute too short',
            ],
            'phone' => [
                'required' => 'We need to know  :attribute ',
                'regex:/(0)[0-9]{9}/' => 'Incorrect  :attribute  format',
            ],
            'email' => [
                'required' => 'We need to know  :attribute ',
                'email:rfc,dns' => 'Incorrect  :attribute  format',
            ],
            'password' => [
                'required',
                Password::min(6)
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->uncompromised(),
            ],

        ];
    }

    public function attributes(): array
    {
        return [
            'fname' => 'First Name',
            'lname' => 'Last Name',
            'gender' => 'Gender',
            'dob' => 'Date of Birth',
            'address' => 'Address',
            'phone' => 'Phone Number',
            'email' => 'Email address',
            'password' => 'Password',
        ];
    }
}
