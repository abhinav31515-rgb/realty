<?php
namespace App\Services;
use App\Models\Property;
use Illuminate\Support\Facades\Storage;
class PropertyService {
    public function getAvailableDisk() {
        if (config('filesystems.disks.s3.key') && config('filesystems.disks.s3.secret')) return 's3';
        if (config('filesystems.disks.supabase.key') && config('filesystems.disks.supabase.secret')) return 'supabase';
        return 'public';
    }
    public function storeImages($files) {
        $disk = $this->getAvailableDisk();
        $paths = [];
        foreach ($files as $file) {
            $path = $file->store('properties', $disk);
            $paths[] = Storage::disk($disk)->url($path);
        }
        return $paths;
    }
}
