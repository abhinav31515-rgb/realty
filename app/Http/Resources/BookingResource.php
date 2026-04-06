<?php
namespace App\Http\Resources;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookingResource extends JsonResource {
    public function toArray(Request $request): array {
        return [
            'id' => $this->id,
            'property' => new PropertyResource($this->whenLoaded('property')),
            'customer' => new UserResource($this->whenLoaded('customer')),
            'agent' => new UserResource($this->whenLoaded('agent')),
            'status' => $this->status,
            'scheduled_at' => $this->scheduled_at ? $this->scheduled_at->toDateTimeString() : null,
            'created_at' => $this->created_at ? $this->created_at->toDateTimeString() : null,
        ];
    }
}
