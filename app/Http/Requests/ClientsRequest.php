<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientsRequest extends FormRequest
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
            'document_type_id'  => 'required',
            'document_number'   => 'required|min:7',
            'names'             => 'required',
            'lastnames'         => 'required',
            'email'             => 'required',
            'phone'             => 'required|min:9|int',
            'address'           => 'required',
            'city'              => 'required',
        ];
    }
}
