<?php

namespace App\Models\Country;

use App\Traits\Loggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CountryTranslation extends Model
{
    use HasFactory, Loggable;

    public $timestamps = false;
    protected $fillable = ['name', 'nationality', 'currency', 'phone_code'];
}
