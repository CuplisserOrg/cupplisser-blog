<?php

namespace Cupplisser\Blog\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BlogPostRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        $rules = [];
        $rules = array_merge($rules, [
            'title'             => 'required|string|max:190',
            'blog_image_id'     => 'nullable|integer',
            'post_content'      => 'required|max:4294967295',
            'format'            => 'sometimes',
            'published_at'      => 'nullable|date',
            'comments_enabled'  => 'required|boolean',
            'tags'              => 'sometimes|string|nullable',
            'is_featured'       => 'sometimes|boolean',
        ]);
        $method = $this->method();

        return $rules;
    }
}
