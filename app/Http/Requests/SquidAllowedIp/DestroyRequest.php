<?php

namespace App\Http\Requests\SquidAllowedIp;

use App\Models\SquidAllowedIp;
use App\Services\SquidAllowedIpService;
use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Foundation\Http\FormRequest;

class DestroyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(Gate $gate, SquidAllowedIpService $squidAllowedIpService): bool
    {
        return $gate->allows('destroy-squid-allowed-ip', $squidAllowedIpService->getById($this->route()->parameter('id')));
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            //
        ];
    }

    public function destroySquidAllowedIp() : SquidAllowedIp
    {
        $ip = SquidAllowedIp::query()->where('id', '=', $this->route()->parameter('id'))->first();

        return $ip;
    }
}
