<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ListProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'product_name' => $this->name,
            'image_path' => $this->image_path,
            'amount' => $this->amount,
            'status' => $this->status,
            'category' => $this->category == null ? null : [
                'category_id' => $this->category->id,
                'category_name' => $this->category->name
            ]
        ];
    }
}
