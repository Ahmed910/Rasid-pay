<?php

namespace App\Models\RasidJob;

use App\Models\Department\Department;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

class RasidJob extends Model implements TranslatableContract
{
    use HasFactory, Uuid, Translatable, SoftDeletes;

    #region properties
    protected $guarded = ['created_at', 'updated_at', 'deleted_at'];
    public $translatedAttributes = ['name', 'description'];
    public $attributes = ['is_active' => false, 'is_vacant' =>  true];
    #endregion properties

    #region mutators
    #endregion mutators

    #region scopes
    public function scopeSearch(Builder $query, $request)
    {

        $query->whereHas("translations", function ($q) use ($request) {
            $q->where('name', 'LIKE', "%$request->name%");
        });


        if (isset($request->department_id)) {
            $query->whereHas("department", function ($q) use ($request) {
                $q->where("id",$request->department_id);
            });
        }


        if (isset($request->is_active)) {

            $query->where('is_active', $request->is_active);
        }

        if (isset($request->is_vacant)) {

            $query->where('is_vacant', $request->is_vacant);
        }

    }
    #endregion scopes

    #region relationships
    public function department()
    {
        return $this->belongsTo(Department::class);
    }
    #endregion relationships

    #region custom Methods
    #endregion custom Methods
}
