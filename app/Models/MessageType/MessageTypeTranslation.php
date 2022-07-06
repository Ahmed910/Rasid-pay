<?php

namespace App\Models\MessageType;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;

class MessageTypeTranslation extends Model
{
    use HasFactory, Uuid;

    #region properties
    public $timestamps = false;
    protected $fillable = ['name'];
    #endregion properties

    #region mutators
    #endregion mutators

    #region scopes
    #endregion scopes

    #region relationships
    #endregion relationships

    #region custom Methods
    #endregion custom Methods
}
