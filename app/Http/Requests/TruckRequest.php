<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TruckRequest extends FormRequest
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
            'number_plate' => 'required|unique:trucks,number_plate,' . ($this->id ? $this->id : -1),
            'truck_manufacturer_id' => 'required',
            'truck_type_id' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'number_plate.unique' => 'Biển kiểm soát đã tồn tại',
        ];
    }
}
