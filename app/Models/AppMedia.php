<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppMedia extends Model
{
    use HasFactory;
    protected $guarded = ['created_at','updated_at','deleted_at'];
    protected $fillable = ['media','option'];

    public function media()
    {

        return $this->morphOne(Media::class, 'mediable');
    }
}
