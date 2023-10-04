<?php

namespace App\Filters;

use Essa\APIToolKit\Filters\QueryFilters;

class RoleFilter extends QueryFilters
{
    protected array $allowedFilters = [
        'role_name',
        'is_active',
        'access_permission'
    ];

    protected array $columnSearch = [
        'role_name',
        'is_active',
        'access_permission'
    ];
}
