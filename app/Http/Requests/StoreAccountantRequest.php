<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Password;

class StoreAccountantRequest extends FormRequest
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
                'nullable',
                'image',
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
                'nullable',
                'string',
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
