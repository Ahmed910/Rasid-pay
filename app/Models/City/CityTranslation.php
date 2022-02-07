<?php

namespace App\Models\City;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;

class CityTranslation extends Model
{
    use HasFactory, Uuid;

    protected $guarded = ['created_at', 'updated_at', 'deleted_at'];
    public $timestamps = false;
}
