<?php

namespace App\Models;

use App\Models\CardPackage\CardPackage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Loggable;
use App\Traits\Uuid;

class Transaction extends Model
{

    use HasFactory, Uuid, Loggable;
    protected $guarded = ['number', 'created_at', 'updated_at'];

    public function cardId()
    {
        return $this->belongsTo(CardPackage::class);
    }
}
