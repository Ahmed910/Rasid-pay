<?php

namespace App\Models;

use App\Models\BankTransfer;
use App\Models\Country\Country;
use App\Models\User;
use App\Traits\Loggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\SoftDeletes;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Currency extends Model
{
    use  Uuid, Loggable;
    #region properties
    protected $guarded = ['created_at','deleted_at'];

    protected $dates = ['last_updated_at'];
    #endregion properties
}
