<?php

namespace App\Models;

use App\Filters\RoleFilter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Essa\APIToolKit\Filters\Filterable;
use Illuminate\Notifications\Notifiable;
class RoleManagement extends Model
{
    use HasFactory, SoftDeletes, Notifiable, Filterable;
    protected $fillable = [
        'role_name',
        'access_permission',
        'is_active'
    ];

    protected $casts = [
        'access_permission'=>'json',
    ];

    protected string $default_filters = RoleFilter::class;
}
