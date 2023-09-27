<?php

namespace App\Filters;

use Essa\APIToolKit\Filters\QueryFilters;

class UserFilter extends QueryFilters
{
    protected array $allowedFilters = [
        'id_prefix',
        'id_no',
        'first_name',
        'middle_name',
        'last_name',
        'sex',
        'role_id',
        'location_name',
        'department_name',
        'company_name',
        'is_active',
        'username'
  
    ];

    protected array $columnSearch = [
        'id_prefix',
        'id_no',
        'first_name',
        'middle_name',
        'last_name',
        'sex',
        'role_id',
        'location_name',
        'department_name',
        'company_name', 
        'is_active',
        'username'
       
    ];
    // public function status($status) {
    //     $this->builder->where()
    // }
}
