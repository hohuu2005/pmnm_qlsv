<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreSinhVienRequest extends FormRequest
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
            'ma_sv'      => 'required|unique:sinh_viens,ma_sv',
            'ho_ten'     => 'required|min:3|max:50',
            'email'      => 'required|email|unique:users,email',
            'lop_hoc_id' => 'required|exists:lop_hocs,id'
        ];
    }
}
