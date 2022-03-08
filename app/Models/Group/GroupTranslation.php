<?php

namespace App\Models\Group;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupTranslation extends Model
{
    use HasFactory, Uuid;

    #region properties
    public $timestamps = false;
    protected $fillable = ['name'];
    #endregion properties
}
