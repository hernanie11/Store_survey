<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RoleManagementRequest extends FormRequest
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
                'role_name' => 'required|unique:role_management,role_name',
                'access_permission' => 'required|array'
            ];
            }
    
            if($this->isMethod('put') &&  ($this->route()->parameter('role'))){
                $id = $this->route()->parameter('role_management');
                return [
                // 'major_category_id' => 'exists:major_categories,id,deleted_at,NULL',
                'role_name' => ['required',Rule::unique('role_management','role_name')->ignore($id)],
                'access_permission' => 'required|array'
                    
                ];
            }
    
            if($this->isMethod('put') && ($this->route()->parameter('id'))){
                return [
                    'status' => 'required|boolean',
                 
                ];
            }
    }
}
