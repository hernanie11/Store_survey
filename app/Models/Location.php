<?php

namespace App\Models;

use App\Filters\LocationFilter;
use Essa\APIToolKit\Filters\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Location extends Model
{
    use HasFactory, Filterable;
    protected $fillable = [
        'location_code',
        'is_active',
        'location_name'
    ];
    protected $casts = [
        'is_active' => 'boolean'
    ];

    protected string $default_filters = LocationFilter::class;
}
