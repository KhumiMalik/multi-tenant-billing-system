<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class InvoiceStoreRequest extends FormRequest {
    public function authorize() {
        return $this->user() != null; // or add role checks
    }

    public function rules() {
        return [
            'account_id' => ['required','exists:accounts,id'],
            'due_date' => ['nullable','date'],
            'notes' => ['nullable','string'],
            'items' => ['required','array','min:1'],
            'items.*.description' => ['required','string'],
            'items.*.quantity' => ['required','integer','min:1'],
            'items.*.unit_price' => ['required','numeric','min:0'],
        ];
    }
}
