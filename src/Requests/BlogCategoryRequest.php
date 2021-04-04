<?php namespace Cupplisser\Blog\Requests;
use Illuminate\Foundation\Http\FormRequest;

class BlogCategoryRequest extends FormRequest{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'description' => 'sometimes|string|nullable'
        ];

        $siteId = getBlogSiteID();

        switch ($this->method())
        {
            case 'POST':
                $rules['name'] = 'required|unique:blog_categories,name,NULL,id,site_id,'.$siteId.',deleted_at,NULL|string';
                break;
            case 'PATCH':
                $rules['name'] = 'required|unique:blog_categories,name,'.$this->category_id.',id,site_id,'.$siteId.'|string';
                break;
        }

        return $rules;
    }
}