<?php

namespace App\Models;

use App\Filters\CompanyFilter;
use Essa\APIToolKit\Filters\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Company extends Model
{
    use HasFactory, Filterable;
    protected $fillable = [
        'company_code',
        'is_active',
        'company_name'
    ];
    protected $casts = [
        'is_active' => 'boolean'
    ];

    protected string $default_filters = CompanyFilter::class;
}
