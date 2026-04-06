<?php
namespace App\Http\Controllers\Api;

use App\Enums\UserRole;
use App\Enums\PropertyStatus;
use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller {
    public function stats(Request $request) {
        $user = $request->user();
        $cacheKey = "user_stats_{$user->id}_{$user->role->value}";

        $stats = Cache::remember($cacheKey, 3600, function() use ($user) {
            if ($user->role === UserRole::ADMIN) {
                return [
                    'total_revenue' => (float) Property::where('status', PropertyStatus::SOLD)->sum('price'),
                    'active_listings' => Property::where('status', PropertyStatus::ACTIVE)->count(),
                    'total_bookings' => Booking::count(),
                    'pending_approvals' => Property::where('status', PropertyStatus::PENDING)->count(),
                ];
            }
            if ($user->role === UserRole::AGENT) {
                return [
                    'total_commissions' => (float) Property::where('owner_id', $user->id)->where('status', PropertyStatus::SOLD)->sum('price') * 0.03,
                    'properties_sold' => Property::where('owner_id', $user->id)->where('status', PropertyStatus::SOLD)->count(),
                    'new_leads' => Booking::where('agent_id', $user->id)->count(),
                ];
            }
            return [
                'saved_properties' => $user->favorites()->count(),
                'upcoming_showings' => Booking::where('customer_id', $user->id)->where('scheduled_at', '>', now())->count(),
            ];
        });

        return response()->json(['data' => $stats]);
    }
}
