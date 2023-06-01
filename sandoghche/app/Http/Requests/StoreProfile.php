<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProfile extends FormRequest
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

        return [
            'name'=>'string|max:50|required',
            'phone_number'=>['string','digits:11',Rule::unique('users','phone_number')->ignore(auth()->user()->id)],
            'avatar'=>'max:4000|mimes:jpg,jpeg,png,gif|dimensions:min_width=300,min_height=300',
        ];
    }
    public function messages()
    {
        return[
            'name.required' => 'نام خود را وارد نمایید',
            'avatar.max' => 'حداکثر حجم مجاز عکس ۴ مگابایت می باشد',
            'avatar.mimes' => 'فقط تصاویر با فرمت jpg png gif مجاز هستند',
            'avatar.dimensions' => 'حداقل طول و عرض مورد نیاز ۳۰۰ پیکسل می باشد',
        ];
    }
}
