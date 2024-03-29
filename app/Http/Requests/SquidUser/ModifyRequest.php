<?php

namespace App\Http\Requests\SquidUser;

use App\Models\SquidUser;
use App\Services\SquidUserService;
use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Foundation\Http\FormRequest;

class ModifyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(Gate $gate, SquidUserService $squidUserService): bool
    {
        $auth = $gate->allows('modify-squid-user',
            $squidUserService->getById($this->route()->parameter('id'))
        );

        return $auth;
    }

    protected function prepareForValidation()
    {
        if (empty($this->enabled)) {
            $this->merge([
                'enabled'=>0,
            ]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'user'=>'min:4|filled|unique:squid_users,user,'.$this->route()->parameter('id').',id',
            'password'=>['required', 'string', 'min:8'],
            'enabled'=>'filled|digits_between:0,1',
            'fullname'=>'nullable',
            'comment'=>'nullable',
        ];
    }

    public function modifySquidUser() : SquidUser
    {
        $squidUser = new SquidUser($this->validated());
        $squidUser->id = $this->route()->parameter('id');

        return $squidUser;
    }
}
