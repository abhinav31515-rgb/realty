<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
use App\Enums\UserRole;
class StoreContentRequest extends FormRequest {
    public function authorize(): bool { 
        return $this->user() && $this->user()->role === UserRole::ADMIN; 
    }
    public function rules(): array {
        return [
            'title' => 'required|string|max:255',
            'slug' => 'required|string|unique:contents,slug',
            'body' => 'required|string',
            'type' => 'required|in:guide,faq,legal,about',
            'metadata' => 'nullable|array',
        ];
    }
}
