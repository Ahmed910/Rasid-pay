<?php

namespace App\Models\Faq;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FaqTranslation extends Model
{
    use HasFactory, Uuid;

    public $timestamps = false;
    protected $fillable = ['question', 'answer'];
}
