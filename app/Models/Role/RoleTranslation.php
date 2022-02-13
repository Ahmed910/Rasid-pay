<?php

namespace App\Models\Role;

use App\Traits\Loggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleTranslation extends Model
{
    use HasFactory, Loggable;

    #region properties
    public $timestamps = false;
    protected $fillable = ['name'];
    #endregion properties
}
