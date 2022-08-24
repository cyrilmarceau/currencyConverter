<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class PairRequest extends FormRequest
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
            'rate' => 'required',
            'currencies.from.symbol' => 'required',
            'currencies.from.name' => 'required',
            'currencies.to.symbol' => 'required',
            'currencies.to.symbol' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'rate.required' => 'Le champ est obligatoire',
            'currencies.from.symbol.required' => 'Le champ est obligatoire',
            'currencies.from.name.required' => 'Le champ est obligatoire',
            'currencies.to.symbol.required' => 'Le champ est obligatoire',
            'currencies.to.symbol.required' => 'Le champ est obligatoire',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'   => 'Validation errors',
            'data'      => $validator->errors()
        ]));
    }
}