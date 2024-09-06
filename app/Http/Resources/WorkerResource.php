<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WorkerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        
        return [
            'id' => $this->id,
            'name' => $this->name,
            'second_name' => $this->second_name,
            'surname' => $this->surname,
            'phone' => $this->phone,
        ];
    }
}
