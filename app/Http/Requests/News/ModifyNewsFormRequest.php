<?php

namespace App\Http\Requests\News;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class ModifyNewsFormRequest extends FormRequest
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
    public function rules(Request $request)
    {
        return [
            'news_id'      =>  'required',
            'news_date'      =>  'required|date',
            'title'             =>  'required|string|max:30',
            'excerpt'           =>  'required|string|max:75',
            'content'       =>  'required',
        ];
    }
}
