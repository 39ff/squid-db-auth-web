<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class UserResource extends JsonResource
{
    public function toArray($request) : array
    {
        return [
            'id'=> $this->resource->id,
            'name'=>$this->resource->name,
            'email'=>$this->resource->email,
            'password'=>'*',
        ];
    }
}
