<?php

namespace App\Models\TransferPurpose;

use App\Models\ActivityLog;
use App\Traits\Loggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;
use Astrotomic\Translatable\Translatable;
use App\Models\BankTransfer;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class TransferPurpose extends Model
{
    use HasFactory, SoftDeletes, Uuid, Translatable, Loggable;

    #region properties
    public $translatedAttributes = ['name','description'];
    protected $attributes = ['is_active' => true];
    protected $guarded = ['created_at','updated_at','deleted_at'];
    #endregion properties

    #region mutators

    #endregion mutators

    #region scopes
    public function scopeSearch(Builder $query, Request $request)
    {
        $old = $query->toSql();
        if ($request->has('name'))
            $query->whereTranslationLike('name', "%$request->name%");

        if ($request->has('is_active') && !in_array($request->is_active, [-1]))
            $query->where('is_active', $request->is_active);

        $new = $query->toSql();
        if ($old != $new) $this->addGlobalActivity($this, $request->query(), ActivityLog::SEARCH, 'index');
    }

    public function scopeSortBy(Builder $query, $request)
    {
        if (!isset($request->sort["column"]) || !isset($request->sort["dir"])) return $query->latest('created_at');

        if (
            !in_array(\Str::lower($request->sort["column"]), $this->sortableColumns) ||
            !in_array(\Str::lower($request->sort["dir"]), ["asc", "desc"])
        ) {
            return $query->latest('created_at');
        }
        $query->when($request->sort, function ($q) use ($request) {
            if ($request->sort["column"]  == "name") {
                return $q->has('translations')
                    ->orderByTranslation($request->sort["column"], @$request->sort["dir"]);
            }
            if ($request->sort["column"] == "is_active") {
                $q->orderBy($request->sort["column"], @$request->sort["dir"]);
            }
            $q->orderBy($request->sort["column"], @$request->sort["dir"]);
        });
    }

    public function scopeActive()
    {
        return $this->where('is_active', true);
    }
    #endregion scopes

    #region relationships
    public function bankTransfer()
    {
        return $this->hasMany(BankTransfer::class);
    }
    #endregion relationships

    #region custom Methods
    #endregion custom Methods
}
