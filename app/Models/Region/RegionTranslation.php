<?php

namespace App\Models\Region;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;

class RegionTranslation extends Model
{
    use HasFactory, Uuid;

    public $timestamps = false;
    protected $guarded = ['created_at', 'updated_at'];
}
