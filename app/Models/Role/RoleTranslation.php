<?php

namespace App\Models\Role;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleTranslation extends Model
{
    use HasFactory, Uuid;

    #region properties
    public $timestamps = false;
    protected $fillable = ['name'];
    #endregion properties
}
