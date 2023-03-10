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
    public $assets = ['logo'];
    protected $guarded = ['created_at', 'deleted_at'];
    public $translatedAttributes = ['name'];
    public $with = ['translations'];
    public $sortableColumns = [
        'name',
        'vendor_name',
        'phone',
        'is_active',
    ];

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
        if (isset($request->vendor_id)) {
            $query->where('vendor_id', $request->vendor_id);
        }

        if (isset($request->address_details)) {
            $query->where('address_details', 'like', "%$request->address_details%");
        }

        if (isset($request->is_active) && in_array($request->is_active, [1, 0])) {
            $query->where('is_active', $request->is_active);
        }
        if (isset($request->phone)) {

            $query->where('phone', 'like', "%$request->phone%");
        }


        $new = $query->toSql();
        if ($old != $new  || $request->is_active == -1) Loggable::addGlobalActivity($this, array_merge($request->query(), $this->searchParams($request)), ActivityLog::SEARCH, 'index');
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
                    ->orderBy($request->sort["column"], @$request->sort["dir"])
                    ->latest('vendor_branches.created_at');
            }

            if ($request->sort["column"] == "vendor_name") {
                // return $q->orderBy('branch_name', $request->sort['dir']);

                return $q->join('vendors','vendors.id','vendor_branches.vendor_id')
                       ->join('vendor_translations','vendor_translations.vendor_id','vendors.id')
                       ->orderBy("vendor_translations.name", $request->sort['dir'])->latest('vendor_branches.created_at');
            }

            if ($request->sort["column"] == "phone") {
                return $q->orderBy('phone', $request->sort['dir'])->latest('vendor_branches.created_at');
            }

            if ($request->sort["column"] == "is_active") {
                $q->orderBy($request->sort["column"], @$request->sort["dir"])->latest('vendor_branches.created_at');
            }

            $q->orderBy($request->sort["column"], @$request->sort["dir"])->latest('vendor_branches.created_at');
        });
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
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
            ->having('distance', '<=', $space_search_by_kilos ?? 10)
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
    private function searchParams($request){
        $searchParams = [];
        if($request->has('is_active')){
            $searchParams['is_active'] = __('dashboard.vendor_branch.active_cases.'. $request->is_active);
        }
        if($request->has('vendor_id')){
            $searchParams['vendor_id'] = Vendor::find($request->vendor_id)?->name;
        }
        return $searchParams;
    }
    #endregion custom Methods
}
