<?php

namespace App\Filters;

use Essa\APIToolKit\Filters\QueryFilters;

class DepartmentFilter extends QueryFilters
{
    protected array $allowedFilters = ['department_code', 'department_name'];

    protected array $columnSearch = ['department_code', 'department_name'];
}
