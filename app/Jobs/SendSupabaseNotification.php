<?php
namespace App\Jobs;
use App\Services\SupabaseService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendSupabaseNotification implements ShouldQueue {
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public function __construct(public int $userId, public string $message, public string $type) {}
    public function handle(SupabaseService $service): void {
        $service->notify($this->userId, $this->message, $this->type);
    }
}
