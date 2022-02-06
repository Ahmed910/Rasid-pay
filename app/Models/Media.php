<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;
    protected $guarded = ['created_at','updated_at','deleted_at'];

        protected $fillable = ['url','mediable_id','mediable_type'];

    public function mediable()
    {
        return $this->morphTo('AppMedia:class');
    }

}
