<?php

namespace App\Models\OurApp;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;

class OurAppTranslation extends Model
{
    use Uuid;

    public $timestamps = false;
    protected $fillable = ['name', 'description'];
}
