<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Property;
use Illuminate\Http\Request;
class BookingController extends Controller {
    public function index(Request $request) {
        $user = $request->user(); $query = Booking::with(['property', 'customer', 'agent']);
        if ($user->role === 'customer') $query->where('customer_id', $user->id);
        elseif ($user->role === 'agent') $query->where('agent_id', $user->id);
        return response()->json($query->get());
    }
    public function store(Request $request) {
        $validated = $request->validate(['property_id' => 'required|exists:properties,id', 'scheduled_at' => 'required|date']);
        $property = Property::findOrFail($validated['property_id']);
        $booking = Booking::create(['property_id' => $property->id, 'customer_id' => $request->user()->id, 'agent_id' => $property->owner_id, 'scheduled_at' => $validated['scheduled_at'], 'status' => 'pending']);
        return response()->json($booking, 201);
    }
    public function updateStatus(Request $request, Booking $booking) {
        $request->validate(['status' => 'required|in:confirmed,cancelled']);
        if ($request->user()->role === 'customer' && $request->status === 'confirmed') return response()->json(['message' => 'Unauthorized'], 403);
        $booking->update(['status' => $request->status]);
        return response()->json($booking);
    }
}
