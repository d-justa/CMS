<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreContactDetailRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'primary_email'       => 'nullable|email|max:255',
            'secondary_email'     => 'nullable|email|max:255',
            'primary_phone'       => 'nullable|string|max:20',
            'secondary_phone'     => 'nullable|string|max:20',
            'street_address1'     => 'nullable|string|max:255',
            'street_address2'     => 'nullable|string|max:255',
            'city'                => 'nullable|string|max:100',
            'state'               => 'nullable|string|max:100',
            'zip_code'            => 'nullable|string|max:20',
            'country'             => 'nullable|string|max:100',
            'contact_map_iframe'  => 'nullable|string',
        ];
    }
}
