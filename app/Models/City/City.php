<?php

namespace App\Models\City;

use Astrotomic\Translatable\Translatable;
use Astrotomic\Translatable\Contracts ;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class City extends Model implements Contracts\Translatable
{
    use HasFactory , SoftDeletes , Translatable ;
    public $translatedAttributes = ['name'];


    protected $guarded = ['created_at','updated_at','deleted_at'];
}
