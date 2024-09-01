<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return[
             'title'=>'required|string|max:255',
             'body'=>'required|string',
             'cover_image'=>'image|mimes:jpeg,png,jpg|max:2048',
             'pinned'=>'required|integer',
             'tags' => 'array',
             'tags.*' => 'exists:tags,id'
        ];
    }

}
