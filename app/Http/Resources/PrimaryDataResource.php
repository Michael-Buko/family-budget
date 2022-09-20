<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PrimaryDataResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'primary_data_id' => $this->id,
            'user_id' => $this->user_id,
            'user_name' => $this->name,
            'date' => $this->date,
            'initial_amount' => $this->initial_amount,
        ];
    }
}
