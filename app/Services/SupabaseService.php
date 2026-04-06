<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SupabaseService {
    protected $url;
    protected $key;

    public function __construct() {
        $this->url = config('services.supabase.url');
        $this->key = config('services.supabase.key');
    }

    public function notify(int $userId, string $message, string $type): bool {
        if (!$this->url || !$this->key) {
            Log::warning("Supabase credentials missing. Skipping notification.");
            return false;
        }

        try {
            $response = Http::withHeaders([
                'apikey' => $this->key,
                'Authorization' => 'Bearer ' . $this->key,
                'Content-Type' => 'application/json',
            ])->post($this->url . '/rest/v1/notifications', [
                'user_id' => $userId,
                'message' => $message,
                'type' => $type
            ]);

            if ($response->failed()) {
                Log::error("Supabase notification failed: " . $response->body());
                return false;
            }

            return true;
        } catch (\Exception $e) {
            Log::error("Supabase error: " . $e->getMessage());
            return false;
        }
    }
}
