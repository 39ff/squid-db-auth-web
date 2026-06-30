<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SquidUserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=> $this->resource->id,
            'user'=>$this->resource->user,
            'password'=>$this->resource->password,
            'enabled'=>$this->resource->enabled,
            'fullname'=>$this->resource->fullname,
            'comment'=>$this->resource->comment,
        ];
    }
}
