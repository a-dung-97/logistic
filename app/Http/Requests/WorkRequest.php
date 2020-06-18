<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WorkRequest extends FormRequest
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
            'date' => 'required',
            'shift' => 'required',
            'customers' => 'required|array|min:1',
            'truck_types' => 'required|min:1',
            'truck_types.*.id' => 'required',
            'truck_types.*.quantity' => 'required|integer|min:1',
        ];
    }
}
