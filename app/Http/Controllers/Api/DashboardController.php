<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\Booking;
use App\Models\Lead;
use Illuminate\Http\Request;
use App\Enums\UserRole;

class DashboardController extends Controller {
    public function stats(Request $request) {
        $user = $request->user();

        if ($user->role === UserRole::ADMIN) {
            return response()->json([
                'total_properties' => Property::count(),
                'total_bookings' => Booking::count(),
                'total_leads' => Lead::count(),
                'total_revenue' => 500000.00, // Hardcoded for luxury demo
            ]);
        }

        if ($user->role === UserRole::AGENT) {
            $propertyIds = $user->properties()->pluck('id');
            return response()->json([
                'my_properties' => $propertyIds->count(),
                'total_bookings' => Booking::whereIn('property_id', $propertyIds)->count(),
                'total_leads' => Lead::whereIn('property_id', $propertyIds)->count(),
            ]);
        }

        return response()->json([
            'saved_properties' => $user->favorites()->count(),
            'my_bookings' => $user->bookings()->count(),
        ]);
    }
}
