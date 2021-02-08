<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'title' => $this->title,
            'city' => $this->city,
            'postcode' => $this->postcode,
            'street_address' => $this->street_address,
            'phone_number' => $this->phone_number,
            'email' => $this->email,
            'updated_at' => $this->updated_at,
            'nutrition' => new NutritionResource($this->whenLoaded('nutrition')),
        ];
    }
}
