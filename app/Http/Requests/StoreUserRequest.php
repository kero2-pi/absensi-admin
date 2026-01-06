<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'name'        => 'required|string|max:255',
            'email'       => 'required|email|unique:users,email',
            'password'    => 'required|min:8',

            'instansi_id' => 'nullable|exists:instansi,id',
            'shift_id'    => 'nullable|exists:shift,id',

            'status'      => 'required|in:PKL,KARYAWAN',
            'mode_kerja'  => 'required|in:WFO,WFH',
        ];
    }
}
