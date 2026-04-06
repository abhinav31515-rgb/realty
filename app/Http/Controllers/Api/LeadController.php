<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\LeadResource;
use App\Models\Lead;
use Illuminate\Http\Request;
use App\Enums\UserRole;

class LeadController extends Controller {
    public function index(Request $request) {
        $user = $request->user();
        
        if ($user->role === UserRole::CUSTOMER) {
            return LeadResource::collection($user->leads()->with('property')->get());
        }

        // Agents see leads for their properties
        return LeadResource::collection(
            Lead::whereHas('property', function($q) use ($user) {
                $q->where('owner_id', $user->id);
            })->with(['property', 'customer'])->get()
        );
    }
}
