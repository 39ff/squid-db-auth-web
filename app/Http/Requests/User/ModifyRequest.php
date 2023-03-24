<?php

namespace App\Http\Requests\User;

use App\Models\User;
use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Foundation\Http\FormRequest;

class ModifyRequest extends FormRequest
{
    public function authorize(Gate $gate) : bool
    {
        $auth = $gate->allows('modify-user', $this->route()->parameter('id'));

        return $auth;
    }

    public function rules(): array
    {
        return [
            'name'=>'filled',
            'email'=>'filled|unique:users,email,'.$this->route()->parameter('id').',id',
            'password'=>['string', 'min:8', 'filled'],
        ];
    }

    public function modifyUser(): User
    {
        $user = new User($this->validated());
        $user->id = $this->route()->parameter('id');

        return $user;
    }
}
