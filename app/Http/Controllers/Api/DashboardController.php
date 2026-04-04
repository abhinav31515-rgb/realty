<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\Booking;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class DashboardController extends Controller {
    public function stats(Request $request) {
        $user = $request->user();
        if ($user->role === 'admin') return response()->json(['total_revenue' => Property::where('status', 'sold')->sum('price'), 'active_listings' => Property::where('status', 'active')->count(), 'total_bookings' => Booking::count(), 'pending_approvals' => Property::where('status', 'pending')->count(), 'revenue_growth' => $this->getRevenueGrowth()]);
        if ($user->role === 'agent') return response()->json(['total_commissions' => Property::where('owner_id', $user->id)->where('status', 'sold')->sum('price') * 0.03, 'properties_sold' => Property::where('owner_id', $user->id)->where('status', 'sold')->count(), 'new_leads' => Booking::where('agent_id', $user->id)->count(), 'listings' => Property::where('owner_id', $user->id)->get()]);
        return response()->json(['saved_properties' => $user->favorites()->with('property')->count(), 'upcoming_showings' => Booking::where('customer_id', $user->id)->where('scheduled_at', '>', now())->count()]);
    }
    private function getRevenueGrowth() { return Property::where('status', 'sold')->select(DB::raw('SUM(price) as total'), DB::raw("to_char(created_at, 'YYYY-MM') as month"))->groupBy('month')->orderBy('month')->get(); }
}
