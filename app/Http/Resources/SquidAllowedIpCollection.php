<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use JsonSerializable;

class SquidAllowedIpCollection extends ResourceCollection
{
    public $collects = SquidAllowedIpResource::class;
    /**
     * Transform the resource collection into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'data'=>$this->collection
        ];
    }
}
