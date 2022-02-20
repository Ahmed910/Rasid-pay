<?php

namespace App\Models\Menu;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuTranslation extends Model
{
    use HasFactory,Uuid;

    public $timestamps = false;
    protected $fillable = ['name'];
}
