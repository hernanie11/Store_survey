<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
        if($this->isMethod('post')){
            return [
                'personal_info.id_no' => 'required|unique:users,id_no',
                'personal_info.first' => 'required',
                'personal_info.last' => 'required',
                'personal_info.username' => 'required|unique:users,username',
                'personal_info.sex' => 'required',
                'location_name' => 'required',
                'department_name' => 'required',
                'company_name' => 'required'

            ];
        }
    }
}
