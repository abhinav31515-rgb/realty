<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
class StoreContentRequest extends FormRequest {
    public function authorize(): bool { return $this->user()->role === 'admin'; }
    public function rules(): array {
        return [
            'title' => 'required|string|max:255',
            'slug' => 'required|string|unique:contents,slug',
            'body' => 'required|string',
            'type' => 'required|string|in:guide,faq,blog',
            'images' => 'nullable|array',
        ];
    }
}
