<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'        => 'sometimes|string|max:255',
            'email'       => 'sometimes|email|unique:users,email,' . $this->user,
            'password'    => 'nullable|min:8',

            'instansi_id' => 'nullable|exists:instansi,id',
            'shift_id'    => 'nullable|exists:shift,id',

            'status'      => 'sometimes|in:PKL,KARYAWAN',
            'mode_kerja'  => 'sometimes|in:WFO,WFH',
            'wajah'       => 'nullable|array',
        ];
    }
}
