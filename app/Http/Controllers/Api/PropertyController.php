<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePropertyRequest;
use App\Http\Requests\UpdatePropertyRequest;
use App\Http\Resources\PropertyResource;
use App\Models\Property;
use App\Services\PropertyService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class PropertyController extends Controller {
    protected $service;
    public function __construct(PropertyService $service) { $this->service = $service; }

    public function index(Request $request) {
        $query = Property::query()->where('status', 'active');
        if ($request->location) $query->where('location', 'like', "%{$request->location}%");
        if ($request->type) $query->where('type', $request->type);
        return PropertyResource::collection($query->paginate(15));
    }

    public function store(StorePropertyRequest $request) {
        $data = $request->validated();
        if ($request->hasFile('images')) {
            $data['images'] = $this->service->storeImages($request->file('images'));
        }
        $data['owner_id'] = $request->user()->id;
        $data['status'] = 'pending';
        return new PropertyResource(Property::create($data));
    }

    public function show(Property $property) {
        $property->increment('views_count');
        return new PropertyResource($property);
    }

    public function update(UpdatePropertyRequest $request, Property $property) {
        Gate::authorize('update', $property);
        $property->update($request->validated());
        return new PropertyResource($property);
    }

    public function destroy(Property $property) {
        Gate::authorize('delete', $property);
        $property->delete();
        return response()->json(['message' => 'Archived']);
    }
}
