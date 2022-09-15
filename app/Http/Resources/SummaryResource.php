<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SummaryResource extends JsonResource
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
            'summary_id' => $this->id,
            'category_id' =>$this->category_id,
            'category' => $this->title,
            'planned_amount' => $this->planned_amount,
        ];
    }
}
