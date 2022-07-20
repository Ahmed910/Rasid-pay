<?php

namespace App\Models\VendorBranches;

use App\Contracts\HasAssetsInterface;
use App\Models\ActivityLog;
use App\Models\Vendor\Vendor;
use App\Traits\{HasAssetsTrait, Loggable, Uuid};
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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
    #region mutators
    public function getLogoAttribute()
    {
        return asset($this->images()->where('option', 'branch_image')->first()?->media);
    }

    public function getVendorLogoAttribute()
    {
        return asset($this->vendor->images()->where('option', 'logo')->first()?->media);
    }
    #endregion mutators

    #region scopes
    public function scopeSearch(Builder $query, $request)
    {
        $old = $query->toSql();

        if (isset($request->name)) {
            $query->where(function ($q) use ($request) {
                $q->whereTranslationLike('name', "%$request->name%");
            });
        }
        $types = Vendor::TYPES;

        if (isset($request->type) && in_array($request->type, $types))
            $query->whereHas("vendor", function ($q) use ($request) {
                $q->where('type', 'like', "%$request->type%");
            });

        if (isset($request->address_details)) {

            $query->where('address_details','like', '%$request->address_details%');
        }

        if (isset($request->is_active) && in_array($request->is_active, [1, 0])) {
            $query->where('is_active', $request->is_active);
        }

        if (isset($request->branch_name))
            $query->whereHas("vendor", function ($q) use ($request) {
                $q->whereTranslationLike('name', "%$request->branch_name%");
            });

        if (isset($request->phone)) {

            $query->where('phone', $request->phone);
        }


        $new = $query->toSql();
        if ($old != $new) $this->addGlobalActivity($this, $request->query(), ActivityLog::SEARCH, 'index');
    }

    public function scopeSortBy(Builder $query, $request)
    {

        if (!isset($request->sort["column"]) || !isset($request->sort["dir"])) return $query->latest('vendor_branches.created_at');

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

            if ($request->sort["column"] == "phone") {
                return $q->orderBy('phone', $request->sort['dir']);
            }

            if ($request->sort["column"] == "type") {
                return $q->orderBy('type', $request->sort['dir']);
            }

            $q->orderBy($request->sort["column"], @$request->sort["dir"]);
        });
    }

    public function scopeNearest($query, $lat, $lng)
    {
        $space_search_by_kilos = setting('space_search_by_kilos');
        return $query->select(\DB::raw("*,
                (6371 * ACOS(COS(RADIANS($lat))
                * COS(RADIANS(lat))
                * COS(RADIANS($lng) - RADIANS(lng))
                + SIN(RADIANS($lat))
                * SIN(RADIANS(lat)))) AS distance"))
            ->having('distance', '<=', $space_search_by_kilos??10)
            ->orderBy('distance', 'asc');
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
