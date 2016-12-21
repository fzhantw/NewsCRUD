<?php

namespace Backpack\NewsCRUD\app\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Validation\Rule;

class ArticleRequest extends \Backpack\CRUD\app\Http\Requests\CrudRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // only allow updates if the user is logged in
        return \Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|min:2|max:255',
//            'slug' => 'unique:articles,slug,'.\Request::get('id'),
            'slug' => Rule::unique('articles')->where('category_id', \Request::get('category_id'))->whereNot('id', \Request::get('id')),
            'content' => 'required|min:2',
            'date' => 'required|date',
            'status' => 'required',
            'category_id' => 'required',
        ];
    }

    /**
     * Get the validation attributes that apply to the request.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'slug' => 'slug(網址)'
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'slug.unique' => '同分類下的 Slug 值必須唯一',
        ];
    }
}
