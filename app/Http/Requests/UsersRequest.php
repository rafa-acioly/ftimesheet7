<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UsersRequest extends FormRequest
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

    public function messages()
    {
        return [
            'name.required'         => 'O nome do usuário é obrigatório.',
            'email.required'        => 'O email do usuário é obrigatório.',
            'email.unique'          => 'O e-mail já está sendo usado por outro usuário.',
            'sector_id.required'    => 'Seleciona o setor do usuário.',
            'password.min'          => 'A senha deve conter no minimo 6 caracteres',
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'sector_id' => 'required|integer|min:1',
            'password' => 'required|min:6'
        ];
    }
}
