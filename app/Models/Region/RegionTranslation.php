<?php

namespace App\Models\Region;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use App\Traits\Uuid;


class RegionTranslation extends Model implements TranslatableContract
{
    use HasFactory, SoftDeletes, Uuid, Translatable;

    public $translatedAttributes = ['name'];
    protected $guarded = ['deleted_at'];
}
