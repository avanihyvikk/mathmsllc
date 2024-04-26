<?php

namespace Modules\cdform\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'cdform_type_id' => 'required|exists:cdform_types,id',
            'serial_number' => 'required',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function messages()
    {
        return [
            'cdform_type_id.required' => 'The cdform type field is required.',
            'cdform_type_id.exists' => 'The cdform type field is not exists.',
        ];
    }
}
