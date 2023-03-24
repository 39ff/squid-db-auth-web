<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class SquidAllowedIpResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array|\Illuminate\Contracts\Support\Arrayable|JsonSerializable
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=> $this->resource->id,
            'ip'=>$this->resource->ip,
        ];
    }
}
