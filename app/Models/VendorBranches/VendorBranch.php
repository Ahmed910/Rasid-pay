<?php

namespace App\Models\VendorBranches;

use App\Contracts\HasAssetsInterface;
use App\Traits\{HasAssetsTrait,Loggable,Uuid};
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use App\Models\ActivityLog;
use App\Models\Vendor\Vendor;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class VendorBranch extends Model implements HasAssetsInterface
{
    use HasFactory, Uuid, HasAssetsTrait, Loggable, Translatable;

    #region properties
    public $assets = ['branch_image'];
    protected $guarded = ['created_at', 'deleted_at'];
    public $translatedAttributes = ['name'];
    #endregion properties
    public static function boot()
    {
        parent::boot();
        static::saved(function ($model) {
            $model->saveAssets($model, request());
        });
    }

    #region mutators
    #endregion mutators

    #region scopes
    public function scopeSearch(Builder $query, $request)
    {
        $old = $query->toSql() ;

        if (isset($request->name)) {
            $query->where(function ($q) use ($request) {
                $q->whereTranslationLike('name', "%\\$request->name%");
            });
        }

       if (isset($request->branch_name) ) {
       $query->where("branch_name", $request->branch_name);
           }

        if (isset($request->type) && in_array($request->type, Vendor::TYPES)) {
            $query->where('type', $request->type);
        }


      if (isset($request->address_details)) {

       $query->where('address_details', $request->address_details);
      }


        $new = $query->toSql() ;
        if ($old!=$new)  $this->addGlobalActivity($this, $request->query(), ActivityLog::SEARCH, 'index');
    }

    public function scopeSortBy(Builder $query, $request)
    {

        if (!isset($request->sort["column"]) || !isset($request->sort["dir"])) return $query->latest('departments.created_at');

        if (
            !in_array(Str::lower($request->sort["column"]), $this->sortableColumns) ||
            !in_array(Str::lower($request->sort["dir"]), ["asc", "desc"])
        ) {
            return $query->latest('vendor_branches.created_at');
        }


        $query->when($request->sort, function ($q) use ($request) {
            if ($request->sort["column"] == "name") {
                return $q->has('translations')
                    ->orderBy($request->sort["column"], @$request->sort["dir"]);
            }

            if ($request->sort["column"] == "branch_name") {
                return $q->orderBy('branch_name', $request->sort['dir']);
            }

            if ($request->sort["column"] == "is_support_maak") {
                return $q->orderBy('is_support_maak', $request->sort['dir']);
            }

            if ($request->sort["column"] == "type") {
                return $q->orderBy('type', $request->sort['dir']);
            }

            $q->orderBy($request->sort["column"], @$request->sort["dir"]);
        });
    }
    #endregion scopes

    #region relationships
    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }
    #endregion relationships

    #region custom Methods
    #endregion custom Methods
}
