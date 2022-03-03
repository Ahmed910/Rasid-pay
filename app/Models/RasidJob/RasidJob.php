<?php

namespace App\Models\RasidJob;

use App\Models\User;
use App\Traits\Uuid;
use App\Traits\Loggable;
use App\Models\Department\Department;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;

class RasidJob extends Model implements TranslatableContract
{
    use HasFactory, Uuid, Translatable, SoftDeletes, Loggable;

    #region properties
    protected $guarded = ['created_at', 'updated_at', 'deleted_at'];
    public $translatedAttributes = ['name', 'description'];
    public $attributes = ['is_active' => false, 'is_vacant' =>  true];
    protected $with = ['translations','addedBy','department'];
    #endregion properties

    #region mutators
    #endregion mutators

    #region scopes
    public function scopeSearch(Builder $query, $request)
    {
        if ($request->name) {
            $query->where(function ($q) use($requst) {
                $q->whereTranslationLike('name', "%$request->name%")->orWhereTranslationLike('description', "%$request->name%");
            });
        }

        if (isset($request->department_id)) {
            $query->whereHas("department", function ($q) use ($request) {
                $q->where("id", $request->department_id);
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


    public function addedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'added_by_id');
    }
    #endregion relationships

    #region custom Methods
    #endregion custom Methods
}
