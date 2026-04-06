<?php
namespace App\Http\Resources;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
class PropertyResource extends JsonResource {
    public function toArray(Request $request): array {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'type' => $this->type,
            'location' => $this->location,
            'price' => (float) $this->price,
            'formatted_price' => '$' . number_format($this->price, 0),
            'images' => $this->images ?? [],
            'status' => $this->status,
            'is_featured' => $this->is_featured,
            'listing_category' => $this->listing_category,
            'specs' => [
                'bhk' => $this->bhk_count,
                'area' => (float) $this->total_area,
                'furnishing' => $this->furnishing_status,
                'possession' => $this->possession_status,
            ],
            'analytics' => [
                'views' => $this->views_count,
                'clicks' => $this->clicks_count,
            ],
            'owner' => new UserResource($this->whenLoaded('owner')),
            'created_at' => $this->created_at->toDateTimeString(),
        ];
    }
}
