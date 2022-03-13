<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class SquidUserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'=> $this->resource->id,
            'user'=>$this->resource->user,
            'password'=>$this->resource->password,
            'enabled'=>$this->resource->enabled,
            'fullname'=>$this->resource->fullname,
            'comment'=>$this->resource->comment
        ];
    }
}
