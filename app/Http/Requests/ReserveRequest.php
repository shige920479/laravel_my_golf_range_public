<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReserveRequest extends FormRequest
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
            "driving_range_id" => ['required', 'exists:driving_ranges,id'],
            "number" => ['required', 'integer', 'between:1,2'],
            "reserve_date" => ['required', 'date', 'after_or_equal:today'],
            "start_time" => ['required', 'date_format:H:i:s', 'before:end_time'],
            "end_time" => ['required', 'date_format:H:i:s', 'after:starta_time'],
            "rental" => ['nullable', 'boolean'],
            "rental_id" => ['nullable', 'exists:reserve_rentals,id'],
            "shower" => ['nullable', 'boolean'],
            "shower_time" => ['nullable', 'date_format:H:i:s', 'after_or_equal:end_time'],
        ];
    }
}
