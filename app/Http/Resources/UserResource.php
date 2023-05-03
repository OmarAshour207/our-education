<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'email'     => $this->email,
            'provider_id' => $this->provider_id,
            'currency'  => $this->currency,
            'balance'   => $this->balance,
            'created_at'    => $this->created_at,
            'transactions'  => TransactionResource::collection($this->transactions)
        ];
    }
}
