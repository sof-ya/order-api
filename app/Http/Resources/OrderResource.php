<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\User;

class OrderResource extends JsonResource
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
            'type_id' => $this->type_id,
            'partnership_id' => $this->partnership_id,
            'user_id' => $this->user_id,
            'description' => $this->description,
            'address' => $this->address,
            'date' => $this->date,
            'amount' => $this->amount,
            'status' => $this->status,
        ];
    }
}
