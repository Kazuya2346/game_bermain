<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Request validation untuk memulai game
 */
class StartGameRequest extends FormRequest
{
    /**
     * Tentukan apakah user boleh melakukan request ini
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Aturan validasi
     */
    public function rules(): array
    {
        return [
            'level' => [
                'required',
                'string',
                'in:low,medium,hard,',
            ],
        ];
    }

    /**
     * Custom error messages
     */
    public function messages(): array
    {
        return [
            'level.required' => 'Level game harus dipilih.',
            'level.in' => 'Level game tidak valid. Pilih: low, medium, hard.',
        ];
    }

    /**
     * Custom attribute names
     */
    public function attributes(): array
    {
        return [
            'level' => 'level game',
        ];
    }
}

// ================================================================

/**
 * Request validation untuk submit jawaban
 */
class SubmitAnswerRequest extends FormRequest
{
    /**
     * Tentukan apakah user boleh melakukan request ini
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Aturan validasi
     */
    public function rules(): array
    {
        return [
            'user_answer' => [
                'required',
                function ($attribute, $value, $fail) {
                    // Validasi: harus string atau array
                    if (!is_string($value) && !is_array($value)) {
                        $fail('Format jawaban tidak valid. Harus berupa teks atau array.');
                    }

                    // Validasi: jika array, tidak boleh kosong
                    if (is_array($value) && empty($value)) {
                        $fail('Jawaban tidak boleh kosong.');
                    }

                    // Validasi: jika string, tidak boleh hanya spasi
                    if (is_string($value) && trim($value) === '') {
                        $fail('Jawaban tidak boleh kosong.');
                    }
                },
            ],
        ];
    }

    /**
     * Custom error messages
     */
    public function messages(): array
    {
        return [
            'user_answer.required' => 'Jawaban tidak boleh kosong.',
        ];
    }

    /**
     * Custom attribute names
     */
    public function attributes(): array
    {
        return [
            'user_answer' => 'jawaban',
        ];
    }

    /**
     * Prepare data untuk validasi
     */
    protected function prepareForValidation(): void
    {
        // Jika answer adalah JSON string, parse ke array
        if ($this->has('user_answer') && is_string($this->user_answer)) {
            $decoded = json_decode($this->user_answer, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                $this->merge([
                    'user_answer' => $decoded,
                ]);
            }
        }
    }
}