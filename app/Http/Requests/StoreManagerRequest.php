<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreManagerRequest extends FormRequest
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
                'unique:App\Models\Manager,phone',
                'unique:App\Models\Accountant,phone',
            ],
            'email' => [
                'required' ,
                'email:rfc,dns',
                'min:10',
                'max:50',
                'unique:App\Models\Employee,email',
                'unique:App\Models\Manager,email',
                'unique:App\Models\Accountant,email',
            ],
            'password' => [
                'nullable',
                'string',
                'regex:^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$',
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
