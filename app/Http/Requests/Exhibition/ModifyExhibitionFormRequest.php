<?php

namespace App\Http\Requests\Exhibition;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class ModifyExhibitionFormRequest extends FormRequest
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
            'exhibition_id'      =>  'required',
            'exhibition_date'      =>  'required',
            'location'      =>  'required',
            'link'      =>  'required',
            'title'             =>  'required|string|max:9',
            'excerpt'           =>  'required|string|max:18',
            'content'       =>  'required|string|max:300',
        ];
    }
}
