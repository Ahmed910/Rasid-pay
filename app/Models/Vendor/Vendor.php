<?php

namespace App\Models\Vendor;

use App\Contracts\HasAssetsInterface;
use App\Models\ActivityLog;
use App\Models\VendorBranches\VendorBranch;
use App\Models\VendorPackage;
use App\Traits\HasAssetsTrait;
use App\Traits\Loggable;
use App\Traits\Uuid;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class Vendor extends Model implements HasAssetsInterface
{
    use HasFactory, Uuid, HasAssetsTrait, Loggable, Translatable;

    #region properties
    const TYPES = ['company', 'institution', 'member', 'freelance_doc', 'famous', 'other'];
    public $assets = ['logo', 'commercial_record_image', 'tax_number_image'];
    protected $guarded = ['created_at'];
    public $translatedAttributes = ['name'];
    private $sortableColumns = ["commercial_record", "is_active", "tax_number", "name", "type", "branches_count",'discount'];
    public $with = ['translations'];
    #endregion properties
    public static function boot()
    {
        parent::boot();
        static::saved(function ($model) {
            $model->saveAssets($model, request());
        });
    }
    #region mutators
    public function setPhoneAttribute($value)
    {
        // if (isset($value) && @$this->attributes['country_code'] == 966){
        //     $this->attributes['phone'] = $this->attributes['country_code'] . $value;
        // }else {
        $this->attributes['phone'] = filter_mobile_number($value);
        // }

    }

    public function getLogoAttribute()
    {
        return asset($this->images()->where('option', 'logo')->first()?->media);
    }

    #region scopes
    public function scopeSearch(Builder $query, Request $request)
    {
        $old = $query->toSql();
        if (isset($request->name))
            $query->whereTranslationLike('name', "%$request->name%");
        if (isset($request->commercial_record))
            $query->where('commercial_record', 'like', "%$request->commercial_record%");
        if (isset($request->tax_number))
            $query->where('tax_number', 'like', "%$request->tax_number%");
        if (isset($request->discount))
            $query->where('discount', 'like', "%$request->discount%");
        if (isset($request->type) && in_array($request->type, self::TYPES))
            $query->where('type', $request->type);
        if (isset($request->is_active) && in_array($request->is_active, [0, 1]))
            $query->where('is_active', $request->is_active);

        $new = $query->toSql();
        if ($old != $new || $request->is_active == -1 ) Loggable::addGlobalActivity($this,array_merge($request->query(), $this->searchParams($request)) , ActivityLog::SEARCH, 'index');
    }

    public function scopeSortBy(Builder $query, $request)
    {
        if (!isset($request->sort["column"]) || !isset($request->sort["dir"])) return $query->latest('vendors.created_at');

        if (
            !in_array(Str::lower($request->sort["column"]), $this->sortableColumns) ||
            !in_array(Str::lower($request->sort["dir"]), ["asc", "desc"])
        ) {
            return $query->latest('vendors.created_at');
        }


        $query->when($request->sort, function ($q) use ($request) {
            if ($request->sort["column"] == "name") {
                return $q->has('translations')
                    ->orderBy($request->sort["column"], @$request->sort["dir"])->latest('vendors.created_at');
            }
            $q->orderBy($request->sort["column"], @$request->sort["dir"])->latest('vendors.created_at');
        });
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
    #endregion scopes

    #region relationships
    public function branches()
    {
        return $this->hasMany(VendorBranch::class, 'vendor_id');
    }

    public function package()
    {
        return $this->hasOne(VendorPackage::class, 'vendor_id');
    }
    #endregion relationships

    #region custom Methods
    private function searchParams($request){
        $searchParams = [];
        if($request->has('is_active')){
            $searchParams['is_active'] = __('dashboard.vendor.active_cases.'. $request->is_active);
        }

        if($request->has('type')){
            $searchParams['type'] = __('dashboard.vendor.type.'. $request->type);
        }
        return $searchParams;
    }
    #endregion custom Methods
}
