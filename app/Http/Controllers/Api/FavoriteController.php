<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Favorite;
use Illuminate\Http\Request;
class FavoriteController extends Controller {
    public function index(Request $request) { return response()->json($request->user()->favorites()->with('property')->get()); }
    public function store(Request $request) {
        $request->validate(['property_id' => 'required|exists:properties,id']);
        $favorite = Favorite::firstOrCreate(['user_id' => $request->user()->id, 'property_id' => $request->property_id]);
        return response()->json($favorite, 201);
    }
    public function destroy(Request $request, $propertyId) {
        Favorite::where('user_id', $request->user()->id)->where('property_id', $propertyId)->delete();
        return response()->json(['message' => 'Removed from favorites']);
    }
}
