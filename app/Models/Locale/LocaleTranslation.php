<?php

namespace App\Models\Locale;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;

class LocaleTranslation extends Model
{
    use HasFactory, Uuid;

    #region properties
    protected $fillable = ['value', 'desc','locale'];
    public $timestamps = false;
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
