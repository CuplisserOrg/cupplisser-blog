<?php namespace Cupplisser\Blog\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BlogTagRequest extends FormRequest{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [];

        switch ($this->method())
        {
            case 'POST':
                $rules['tags'] = 'required|string';
                break;
            case 'PATCH':
                $rules['tag'] = 'required|string';
                break;
        }

        return $rules;
    }

}