<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TruckManufacturerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'code' => strtolower(str_replace(' ', '', $this->code)),
        ]);
    }
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
            'name' => 'required|unique:truck_manufacturers,name,' . ($this->id ? $this->id : -1),
            'code' => 'required|unique:truck_manufacturers,code,' . ($this->id ? $this->id : -1),
        ];
    }
    public function messages()
    {
        return [
            'name.unique' => 'Tên đã tồn tại',
            'code.unique' => 'Mã đã tồn tại'
        ];
    }
}
