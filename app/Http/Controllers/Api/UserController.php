<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use App\Enums\UserRole;

class UserController extends Controller {
    public function index(Request $request) {
        $user = $request->user();
        if ($user->role !== UserRole::ADMIN) {
            abort(403, 'Unauthorized');
        }

        return UserResource::collection(User::paginate(20));
    }

    public function updateRole(Request $request, User $user) {
        if ($request->user()->role !== UserRole::ADMIN) {
            abort(403, 'Unauthorized');
        }

        $request->validate(['role' => 'required|in:admin,agent,customer']);
        
        $user->update(['role' => $request->role]);

        return new UserResource($user);
    }
}
