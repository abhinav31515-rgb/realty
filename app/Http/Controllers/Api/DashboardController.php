<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller {
    public function stats(Request $request) {
        $user = $request->user();
        $cacheKey = "user_stats_{$user->id}_{$user->role}";

        return Cache::remember($cacheKey, 3600, function() use ($user) {
            if ($user->role === 'admin') {
                return [
                    'total_revenue' => Property::where('status', 'sold')->sum('price'),
                    'active_listings' => Property::where('status', 'active')->count(),
                    'total_bookings' => Booking::count(),
                    'pending_approvals' => Property::where('status', 'pending')->count(),
                ];
            }
            if ($user->role === 'agent') {
                return [
                    'total_commissions' => Property::where('owner_id', $user->id)->where('status', 'sold')->sum('price') * 0.03,
                    'properties_sold' => Property::where('owner_id', $user->id)->where('status', 'sold')->count(),
                    'new_leads' => Booking::where('agent_id', $user->id)->count(),
                ];
            }
            return [
                'saved_properties' => $user->favorites()->count(),
                'upcoming_showings' => Booking::where('customer_id', $user->id)->where('scheduled_at', '>', now())->count(),
            ];
        });
    }
}
