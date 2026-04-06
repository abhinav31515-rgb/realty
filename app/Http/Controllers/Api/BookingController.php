<?php
namespace App\Http\Controllers\Api;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBookingRequest;
use App\Http\Resources\BookingResource;
use App\Mail\ShowingRequestedMail;
use App\Models\Booking;
use App\Models\Property;
use App\Services\SupabaseService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;

class BookingController extends Controller {
    protected $supabase;

    public function __construct(SupabaseService $supabase) {
        $this->supabase = $supabase;
    }

    public function index(Request $request): AnonymousResourceCollection {
        $user = $request->user();
        $query = Booking::with(['property', 'customer', 'agent']);

        if ($user->role === UserRole::CUSTOMER) {
            $query->where('customer_id', $user->id);
        } elseif ($user->role === UserRole::AGENT) {
            $query->where('agent_id', $user->id);
        }

        return BookingResource::collection($query->get());
    }

    public function store(StoreBookingRequest $request): BookingResource {
        $property = Property::findOrFail($request->property_id);

        $booking = Booking::create([
            'property_id' => $property->id,
            'customer_id' => $request->user()->id,
            'agent_id' => $property->owner_id,
            'scheduled_at' => $request->scheduled_at,
            'status' => 'pending',
        ]);

        $this->supabase->notify($property->owner_id, "New showing request for {$property->title}", "booking");
        
        try {
            Mail::to($booking->agent->email)->send(new ShowingRequestedMail($booking));
        } catch (\Exception $e) {
            \Log::error("Mail failed: " . $e->getMessage());
        }

        return new BookingResource($booking->load(['property', 'customer', 'agent']));
    }

    public function updateStatus(Request $request, Booking $booking): BookingResource {
        Gate::authorize('update', $booking);
        
        $request->validate(['status' => 'required|in:confirmed,cancelled']);
        
        if ($request->user()->role === UserRole::CUSTOMER && $request->status === 'confirmed') {
            abort(403, 'Only agents can confirm bookings.');
        }

        $booking->update(['status' => $request->status]);

        $this->supabase->notify($booking->customer_id, "Your showing for {$booking->property->title} is {$request->status}", "status_update");

        return new BookingResource($booking->load(['property', 'customer', 'agent']));
    }
}
