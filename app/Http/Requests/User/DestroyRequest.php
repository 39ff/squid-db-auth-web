<?php

namespace App\Http\Requests\User;

use App\Models\User;
use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Foundation\Http\FormRequest;

class DestroyRequest extends FormRequest
{
    public function authorize(Gate $gate)
    {
        $auth = $gate->allows('destroy-user', $this->route()->parameter('id'));

        return $auth;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [

        ];
    }

    public function destroyUser(): User
    {
        $user = User::query()->where('id', '=', $this->route()->parameter('id'))->first();

        return $user;
    }
}
