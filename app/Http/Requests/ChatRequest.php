<?php

namespace App\Http\Requests;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ChatRequest extends FormRequest
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

    // Validationエラー時の処理を上書きする
    protected function failedValidation(Validator $validator)
    {
        $response['user'] = null; 
        $response['errors']  = $validator->errors()->toArray();
        throw new HttpResponseException(
            response()->json($response, 422)
        );
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user' => 'required:max:30',
            'comment' => 'required:max:120'
        ];
    }
}
