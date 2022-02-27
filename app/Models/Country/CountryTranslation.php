<?php

namespace App\Models\Country;

use App\Traits\Loggable;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CountryTranslation extends Model
{
    use HasFactory, Loggable, Uuid;

    public $timestamps = false;
    protected $fillable = ['name', 'nationality', 'currency', 'phone_code'];
}
