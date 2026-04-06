<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Mail\WelcomeLuxuryMail;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'string|in:admin,agent,customer',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role ?? 'customer',
        ]);

        try {
            Mail::to($user->email)->send(new WelcomeLuxuryMail($user));
        } catch (\Exception $e) {
            \Log::error("Failed to send welcome email to {$user->email}: " . $e->getMessage());
        }

        return response()->json([
            'user' => new UserResource($user),
            'token' => $user->createToken('auth_token')->plainTextToken,
        ]);
    }

    public function login(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        return response()->json([
            'user' => new UserResource($user),
            'token' => $user->createToken('auth_token')->plainTextToken,
        ]);
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out']);
    }

    public function me(Request $request): UserResource
    {
        return new UserResource($request->user());
    }
}
