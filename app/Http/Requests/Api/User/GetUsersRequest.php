<?php

namespace App\Http\Requests\Api\User;

use Illuminate\Foundation\Http\FormRequest;

class GetUsersRequest extends FormRequest
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
            'page' => 'nullable|integer|min:1',
            'count' => 'nullable|integer|min:5|max:100',
            'offset' => 'nullable|integer|min:0'
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'page' => $this->page ?? 1,
            'count' => $this->count ?? 5,
            'offset' => $this->offset
        ]);
    }
}
