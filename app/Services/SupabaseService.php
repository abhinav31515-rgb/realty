<?php
namespace App\Services;
use Illuminate\Support\Facades\Http;
class SupabaseService {
    protected $url;
    protected $key;
    public function __construct() {
        $this->url = config('services.supabase.url');
        $this->key = config('services.supabase.key');
    }
    public function notify($userId, $message, $type) {
        if (!$this->url || !$this->key) return;
        Http::withHeaders([
            'apikey' => $this->key,
            'Authorization' => 'Bearer ' . $this->key,
            'Content-Type' => 'application/json',
        ])->post($this->url . '/rest/v1/notifications', [
            'user_id' => $userId,
            'message' => $message,
            'type' => $type
        ]);
    }
}
