<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
class StorePropertyRequest extends FormRequest {
    public function authorize(): bool { return true; }
    public function rules(): array {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'type' => 'required|string|in:Villa,Penthouse,Mansion,Estate',
            'location' => 'required|string',
            'price' => 'required|numeric|min:0',
            'listing_category' => 'required|in:buy,rent,commercial',
            'bhk_count' => 'nullable|integer|min:0',
            'total_area' => 'nullable|numeric|min:0',
            'images.*' => 'image|mimes:jpeg,png,jpg,webp|max:10240',
        ];
    }
}
