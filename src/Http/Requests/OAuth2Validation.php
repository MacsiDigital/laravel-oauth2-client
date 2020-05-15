<?php

namespace MacsiDigital\OAuth2\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OAuth2Validation extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->state == $this->cookie('oauth2state');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'code' => 'required',
        ];
    }
}
