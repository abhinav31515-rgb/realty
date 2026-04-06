<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePropertyRequest;
use App\Http\Requests\UpdatePropertyRequest;
use App\Http\Resources\PropertyResource;
use App\Models\Property;
use App\Services\PropertyService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class PropertyController extends Controller {
    protected $service;

    public function __construct(PropertyService $service) {
        $this->service = $service;
    }

    public function index(Request $request) {
        $query = Property::query()
            ->active()
            ->filterByCategory($request->category);

        if ($request->location) {
            $query->where('location', 'like', "%{$request->location}%");
        }

        if ($request->type) {
            $query->whereIn('type', explode(',', $request->type));
        }

        if ($request->min_price) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->max_price) {
            $query->where('price', '<=', $request->max_price);
        }

        return PropertyResource::collection($query->paginate($request->per_page ?? 15));
    }

    public function store(StorePropertyRequest $request) {
        $data = $request->validated();

        if ($request->hasFile('images')) {
            $data['images'] = $this->service->storeImages($request->file('images'));
        }

        $data['owner_id'] = $request->user()->id;
        $data['status'] = 'pending';

        $property = Property::create($data);

        return new PropertyResource($property);
    }

    public function show(Property $property) {
        $property->increment('views_count');
        return new PropertyResource($property->load('owner'));
    }

    public function update(UpdatePropertyRequest $request, Property $property) {
        Gate::authorize('update', $property);
        
        $property->update($request->validated());

        return new PropertyResource($property);
    }

    public function destroy(Property $property): JsonResponse {
        Gate::authorize('delete', $property);
        
        $property->delete();

        return response()->json(['message' => 'Archived successfully']);
    }

    public function incrementClick(Property $property): JsonResponse {
        $property->increment('clicks_count');
        return response()->json(['success' => true]);
    }
}
