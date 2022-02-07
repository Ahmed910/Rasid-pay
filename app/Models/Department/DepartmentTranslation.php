<?php

namespace App\Models\Department;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepartmentTranslation extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $guarded = ['created_at', 'updated_at'];
}
