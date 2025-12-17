<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Will use policy for authorization
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:500',
            'domain' => 'nullable|string|max:255',
            'asking_price' => 'required|numeric|min:0',
            'category' => 'required|in:saas,ecommerce,content,tool,game,other',
            'story' => 'required|string|max:1000',
            'tech_stack' => 'nullable|string|max:255',
            'monthly_traffic' => 'nullable|integer|min:0',
            'total_revenue' => 'nullable|numeric|min:0',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'contact_email' => 'nullable|email',
        ];
    }
}
