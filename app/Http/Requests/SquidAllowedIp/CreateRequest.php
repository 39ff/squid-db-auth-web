<?php

namespace App\Http\Requests\SquidAllowedIp;

use App\Models\SquidAllowedIp;
use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(Gate $gate): bool
    {
        $auth = $gate->allows('create-squid-allowed-ip', $this->route()->parameter('user_id'));

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
            'ip'=>'required|ip|unique:squid_allowed_ips',
        ];
    }

    public function createSquidAllowedIp() : SquidAllowedIp
    {
        $squidAllowedIp = new SquidAllowedIp($this->validated());
        $squidAllowedIp->user_id = $this->route()->parameter('user_id');

        return $squidAllowedIp;
    }
}
