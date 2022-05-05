<?php

namespace App\Http\Requests\SquidUser;

use App\Services\SquidUserService;
use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Foundation\Http\FormRequest;

class ReadRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(Gate $gate,SquidUserService $squidUserService)
    {
        $auth =  $gate->allows('modify-squid-user',
            $squidUserService->getById($this->route()->parameter('id'))
        );
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
}
