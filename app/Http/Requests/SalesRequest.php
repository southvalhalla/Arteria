<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SalesRequest extends FormRequest
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
            'client_id'         => 'required',
            'date'              => 'required',
            'productSelected'   => 'required',
            'quantity'          => 'required',
            'confirm_method'    => 'required',
            'name'              => 'required|min:3',
            'lastName'          => 'required|min:3',
            'number_account'    => 'min:10',
            'security_cod'      => 'min:4|max:4',
        ];
    }
}
