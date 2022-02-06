<?php

namespace App\Models\Region;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;


class RegionTranslation extends Model
{
    use HasFactory, Uuid;

    protected $table = 'country_translations';
    public $timestamps = false;
    protected $guarded = [];
}
