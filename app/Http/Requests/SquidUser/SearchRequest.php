<?php

namespace App\Http\Requests\SquidUser;

use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Foundation\Http\FormRequest;

class SearchRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(Gate $gate): bool
    {
        $auth = $gate->allows('search-squid-user', $this->route()->parameter('user_id'));

        return $auth;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'per'=>'digits_between:1,100',
        ];
    }

    public function searchSquidUser(): array
    {
        $validated = $this->validated();

        return $validated;
    }
}
