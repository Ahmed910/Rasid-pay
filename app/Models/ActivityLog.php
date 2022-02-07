<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\SoftDeletes;

class ActivityLog extends Model
{
    use HasFactory, Uuid, SoftDeletes;

    #region properties
    protected $guarded = ['created_at', 'updated_at', 'deleted_at'];
    #endregion properties

    #region mutators
    #endregion mutators

    #region scopes
    #endregion scopes

    #region relationships
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    #endregion relationships

    #region custom Methods
    #endregion custom Methods

}
