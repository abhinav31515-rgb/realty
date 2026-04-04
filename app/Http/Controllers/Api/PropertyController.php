<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PropertyController extends Controller
{
    public function index(Request $request)
    {
        $query = Property::query();

        if ($request->has('location')) {
            $query->where('location', 'like', '%' . $request->location . '%');
        }
        if ($request->has('type')) {
            $query->where('type', $request->type);
        }
        if ($request->has('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->has('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        return response()->json($query->paginate(15));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'type' => 'required|string',
            'location' => 'required|string',
            'price' => 'required|numeric',
            'images.*' => 'image|mimes:jpeg,png,jpg,webp|max:5120', // 5MB max for high-res
            'metadata' => 'array',
            'is_featured' => 'boolean',
        ]);

        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                // In production, this would use 's3' or 'cloudinary' driver
                $path = $image->store('properties', 'public');
                $imagePaths[] = Storage::disk('public')->url($path);
            }
        }

        $validated['images'] = $imagePaths;
        $validated['owner_id'] = $request->user()->id;

        $property = Property::create($validated);
        return response()->json($property, 201);
    }

    public function show(Property $property)
    {
        return response()->json($property);
    }

    public function update(Request $request, Property $property)
    {
        if ($request->user()->id !== $property->owner_id && $request->user()->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $property->update($request->all());
        return response()->json($property);
    }

    public function destroy(Request $request, Property $property)
    {
        if ($request->user()->id !== $property->owner_id && $request->user()->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $property->delete();
        return response()->json(['message' => 'Deleted']);
    }
}

    public function incrementClick(Property $property)
    {
        $property->increment('clicks_count');
        return response()->json(['success' => true]);
    }
