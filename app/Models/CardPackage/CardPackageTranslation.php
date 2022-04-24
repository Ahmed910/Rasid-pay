<?php

namespace App\Models\CardPackage;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CardPackageTranslation extends Model
{
    use HasFactory, Uuid;

    #region properties
    public $timestamps = false;
    protected $fillable = ['name', 'description'];
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
