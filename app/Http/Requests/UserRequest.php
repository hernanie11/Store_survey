<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
                'location' => 'required',
                'department' => 'required',
                'company' => 'required'

            ];
        }

        if($this->isMethod('put') &&  ($this->route()->parameter('user'))){
            $id = $this->route()->parameter('user');
            return [
            // 'major_category_id' => 'exists:major_categories,id,deleted_at,NULL',
                // 'username' => ['required',Rule::unique('users','username')->ignore($id)],
                'role_id' => 'required|exists:role_management,id'
                
            ];
        }


        if($this->isMethod('put') && ($this->route()->parameter('id'))){
            return [
                'status' => 'required|boolean',
                // 'id' => 'exists:major_categories,id',
            ];
        }
    }
}
