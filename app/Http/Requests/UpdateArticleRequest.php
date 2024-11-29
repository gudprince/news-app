<?php

namespace App\Http\Requests;

use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateArticleRequest extends FormRequest
{   
    use ApiResponse;

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
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'author' => 'nullable|string|max:255',
            'source_name' => 'nullable|string|max:255',
            'published_at' => 'nullable|date',
            'category_id' => 'required|exists:categories,id',
            'article_url' => 'required|url',
            'slug' => 'required|string|unique:articles,slug,' . $this->route('article'),
            'image_url' => 'nullable|url',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();

        throw new HttpResponseException(
            $this->errorResponse('Validation Error', JsonResponse::HTTP_BAD_REQUEST, $errors)
        );
    }
}
