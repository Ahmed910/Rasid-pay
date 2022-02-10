<?php

namespace App\Models\City;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Loggable;

class CityTranslation extends Model
{
    use HasFactory, Loggable;

    protected $guarded = ['created_at', 'updated_at', 'deleted_at'];
    public $timestamps = false;
}
