<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Storage;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|string|min:2|max:60',
            'email' => 'required|string|unique:App\Models\User,email',
            'phone' => 'required|string|unique:App\Models\User,phone|regex:/^[\+]{0,1}380([0-9]{9})$/',
            'photo' => 'required|file|max:5120',
            'position_id' => 'required|numeric|exists:App\Models\Position,id',
        ];
    }
}
