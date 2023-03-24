<?php

namespace App\Http\Requests\SquidAllowedIp;

use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Foundation\Http\FormRequest;

class SearchRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(Gate $gate): bool
    {
        return $gate->allows('search-squid-allowed-ip', $this->route()->parameter('user_id'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'per'=>'digits_between:1,100',
        ];
    }

    public function searchSquidAllowedIp()
    {
        $validated = $this->validated();

        return $validated;
    }
}
