<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'username' => 'required|unique:users,username,' . ($this->id ? $this->id : -1),
            'email' => 'required|unique:users,email,' . ($this->id ? $this->id : -1),
            'phone_number' => 'required|unique:users,phone_number,' . ($this->id ? $this->id : -1),
            'password' => $this->id ? 'min:6|confirmed' : 'required|min:6|confirmed',
            'password_confirmation' => $this->id ? '' : 'required',
            'role_id' => 'required'
        ];
    }
}
