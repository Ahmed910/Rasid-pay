<?php

namespace App\Models\Region;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Region extends Model
{
    use HasFactory, SoftDeletes, Uuid;

    protected $guarded = ['created_at', 'updated_at', 'deleted_at'];
}
