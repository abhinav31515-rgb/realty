<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Resources\BookingResource;
use App\Mail\ShowingRequestedMail;
use App\Models\Booking;
use App\Models\Property;
use App\Services\SupabaseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class BookingController extends Controller {
    protected $supabase;
    public function __construct(SupabaseService $supabase) { $this->supabase = $supabase; }

    public function index(Request $request) {
        $user = $request->user();
        $query = Booking::with(['property', 'customer', 'agent']);
        if ($user->role === 'customer') $query->where('customer_id', $user->id);
        elseif ($user->role === 'agent') $query->where('agent_id', $user->id);
        return BookingResource::collection($query->get());
    }

    public function store(Request $request) {
        $validated = $request->validate(['property_id' => 'required|exists:properties,id', 'scheduled_at' => 'required|date']);
        $property = Property::findOrFail($validated['property_id']);
        $booking = Booking::create([
            'property_id' => $property->id,
            'customer_id' => $request->user()->id,
            'agent_id' => $property->owner_id,
            'scheduled_at' => $validated['scheduled_at'],
            'status' => 'pending',
        ]);
        $this->supabase->notify($property->owner_id, "New showing request for {$property->title}", "booking");
        Mail::to($booking->agent->email)->send(new ShowingRequestedMail($booking));
        return new BookingResource($booking);
    }

    public function updateStatus(Request $request, Booking $booking) {
        $request->validate(['status' => 'required|in:confirmed,cancelled']);
        if ($request->user()->role === 'customer' && $request->status === 'confirmed') return response()->json(['message' => 'Unauthorized'], 403);
        $booking->update(['status' => $request->status]);
        $this->supabase->notify($booking->customer_id, "Your showing for {$booking->property->title} is {$request->status}", "status_update");
        return new BookingResource($booking);
    }
}
