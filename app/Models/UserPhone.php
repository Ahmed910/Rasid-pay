<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Uuid;

class UserPhone extends Model
{
    use  HasFactory, Uuid ;

    #region properties
    protected $guarded = ['created_at','updated_at'];
    protected $casts = [ 'verified_at' => 'datetime'];

    #endregion properties

    #region mutators
    #endregion mutators

    #region scopes
    #endregion scopes

    #region relationships

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    #endregion relationships

    #region custom Methods
    #endregion custom Methods
}
