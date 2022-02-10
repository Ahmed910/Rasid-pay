<?php

namespace App\Models\Region;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Loggable;


class RegionTranslation extends Model
{
    use HasFactory, Loggable;

    public $timestamps = false;
    protected $guarded = ['created_at', 'updated_at'];
}
