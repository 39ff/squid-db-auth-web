<?php

namespace App\Http\Requests\SquidUser;

use App\Models\SquidUser;
use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(Gate $gate)
    {
        $auth =  $gate->allows('create-squid-user',$this->route()->parameter('user_id'));
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
            'user'=>'required|unique:squid_users',
            'password'=>'required',
            'enabled'=>'required',
            'fullname'=>'filled',
            'comment'=>'filled'
        ];
    }

    public function createSquidUser() : SquidUser
    {
        $squidUser = new SquidUser($this->validated());
        $squidUser->user_id = $this->route()->parameter('user_id');
        return $squidUser;
    }
}
