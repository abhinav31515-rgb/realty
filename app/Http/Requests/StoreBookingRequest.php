<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
class StoreBookingRequest extends FormRequest {
    public function authorize(): bool { return true; }
    public function rules(): array {
        return [
            'property_id' => 'required|exists:properties,id',
            'scheduled_at' => 'required|date|after:now',
        ];
    }
}
