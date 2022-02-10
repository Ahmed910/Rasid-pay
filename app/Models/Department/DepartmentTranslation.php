<?php

namespace App\Models\Department;

use App\Traits\Loggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepartmentTranslation extends Model
{
    use HasFactory, Loggable;

    public $timestamps = false;
    protected $fillable = ['name', 'description'];
}
