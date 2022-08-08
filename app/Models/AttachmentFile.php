<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;

class AttachmentFile extends Model
{
    use HasFactory, Uuid;

    #region properties
    protected $guarded = ['created_at','deleted_at'];

    #endregion properties

    #region mutators
    #endregion mutators

    #region scopes
    #endregion scopes

    #region relationships
    public function attachment () {
        return $this->belongsTo(Attachment::class) ;
    }
    #endregion relationships

    #region custom Methods
    #endregion custom Methods
}
