<?php

namespace App\Models\Department;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaticPageTranslation extends Model
{
    use HasFactory, Uuid;

    public $timestamps = false;
    protected $fillable = ['name', 'description'];
}
