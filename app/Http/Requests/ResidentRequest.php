<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Http\FormRequest;

class ResidentRequest extends FormRequest
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
        // Ambil ID resident kalau ada (untuk update)
        $resident = $this->route('user');
        // dd($resident);
        $user = User::with('profile')->find($resident);

        return [
            'name' => ['required', 'string'],
            'username' => ['required', 'string',
                Rule::unique('users', 'username')->ignore($user->id ?? null),
            ],
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($user->id ?? null),
            ],
            'password' => [
                $this->isMethod('post') ? 'required' : 'nullable',
                'string',
                'min:8',
            ],
            'nik' => [
                'required',
                'string',
                'min:15',
                Rule::unique('profiles', 'nik')->ignore($user->profile->id ?? null),
            ],
            'kk' => ['required', 'string', 'min:15'],
            'birth_place' => ['required', 'string'],
            'birth_date' => ['required', 'date'],
            'gender' => ['required', 'in:Laki-laki,Perempuan'],
            'nationality' => ['required', 'string'],
            'religion' => ['required', 'string'],
            'marital_status' => ['required', 'string'],
            'occupation' => ['required', 'string'],
            'address_ktp' => ['required', 'string'],
            'address_domisili' => ['required', 'string'],
        ];
    }
}
