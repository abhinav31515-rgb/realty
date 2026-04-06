<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
class UpdatePropertyRequest extends FormRequest {
    public function authorize(): bool { return true; }
    public function rules(): array {
        return [
            'title' => 'string|max:255',
            'description' => 'string',
            'status' => 'string|in:active,pending,sold,rejected',
            'price' => 'numeric|min:0',
        ];
    }
}
