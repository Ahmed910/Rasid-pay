<?php

namespace App\Models\Currency;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;

class CurrencyTranslation extends Model
{
    use HasFactory, Uuid;

    public $timestamps = false;
    protected $guarded = ['created_at', 'updated_at'];
}
