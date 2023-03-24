<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use JsonSerializable;

class SquidAllowedIpCollection extends ResourceCollection
{
    public $collects = SquidAllowedIpResource::class;

    /**
     * Transform the resource collection into an array.
     *
     * @return array|\Illuminate\Contracts\Support\Arrayable|JsonSerializable
     */
    public function toArray(Request $request): array
    {
        return [
            'data'=>$this->collection,
        ];
    }
}
