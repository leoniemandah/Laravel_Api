<?php

namespace App\Http\Requests\Profile;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Allow all users to access this request.
    }

    public function rules(): array
    {
        return [
            'lastName' => 'required|string|max:255',
            'firstName' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|string|in:actif,inactif,en attente',
        ];
    }
}