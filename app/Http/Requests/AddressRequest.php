<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class AddressRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'receiver_name' => ['required', 'string', 'max:255'],
            'phone'         => ['required', 'string', 'max:20'],
            'full_address'  => ['required', 'string', 'max:255'],
            'city'          => ['required', 'string', 'max:100'],
            'district'      => ['required', 'string', 'max:100'],
            'ward'          => ['required', 'string', 'max:100'],
        ];
    }
}
