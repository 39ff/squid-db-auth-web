<?php

namespace App\Http\Requests\User;

use App\Models\User;
use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Foundation\Http\FormRequest;

class SearchRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(Gate $gate): bool
    {
        $auth = $gate->allows('search-user');

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

    public function searchUser(): array
    {
        $validated = $this->validated();

        return $validated;
    }
}
