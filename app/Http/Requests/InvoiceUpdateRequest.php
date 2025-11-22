<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class InvoiceUpdateRequest extends FormRequest {
    public function authorize() { return $this->user() != null; }

    public function rules() {
        return [
            'due_date' => ['nullable','date'],
            'notes' => ['nullable','string'],
            'status' => ['nullable','in:pending,sent,paid'],
            'items' => ['sometimes','array','min:1'],
            'items.*.description' => ['required_with:items','string'],
            'items.*.quantity' => ['required_with:items','integer','min:1'],
            'items.*.unit_price' => ['required_with:items','numeric','min:0'],
        ];
    }
}
