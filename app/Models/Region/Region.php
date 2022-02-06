<?php

namespace App\Models\Region;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;



class Region  extends Model implements TranslatableContract
{
    use HasFactory, SoftDeletes, Uuid,Translatable;
    public $translatedAttributes = ['name'];
    protected $guarded = ['created_at', 'updated_at', 'deleted_at'];
}
