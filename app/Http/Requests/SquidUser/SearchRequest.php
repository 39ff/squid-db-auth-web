<?php

namespace App\Http\Requests\SquidUser;

use App\Models\SquidUser;
use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Foundation\Http\FormRequest;

class SearchRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(Gate $gate)
    {
        $auth =  $gate->allows('search-squid-user',$this->route()->parameter('user_id'));
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
            'per'=>'digits_between:1,100',
        ];
    }

    public function searchSquidUser(){
        $squidUser = new SquidUser($this->validated());
        $squidUser->user_id = $this->route()->parameter('user_id');

        return $squidUser;
    }

}
