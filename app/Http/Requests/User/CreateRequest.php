<?php

namespace App\Http\Requests\User;

use App\Models\User;
use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(Gate $gate) : bool
    {
        $auth = $gate->allows('create-user');

        return $auth;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name'=>'required',
            'email'=>'required|unique:users',
            'password'=>['required', 'string', 'min:8'],
        ];
    }

    public function createUser() : User
    {
        return new User($this->validated());
    }
}
