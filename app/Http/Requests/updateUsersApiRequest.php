<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class updateUsersApiRequest extends FormRequest
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
            'name'=>'required|min:3|max:64|unique:users',
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Необходимо ввести имя в поле',
            'name.min' => 'Имя должно быть не менее 3 символов',
            'name.max' => 'Имя не должно быть длиннее 64 символов',
        ];
    }
}
