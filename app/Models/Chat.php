<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Uuid;


class Chat extends Model
{
    use HasFactory, SoftDeletes, Uuid;

    protected $guarded = ['created_at', 'updated_at', 'deleted_at'];
}
