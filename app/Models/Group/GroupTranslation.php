<?php

namespace App\Models\Group;

use App\Traits\{Loggable, Uuid};
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupTranslation extends Model
{
    use HasFactory, Uuid , Loggable;

    #region properties
    public $timestamps = false;
    protected $fillable = ['name'];
    #endregion properties
}
