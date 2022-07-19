<?php

namespace App\Models\Vendor;

use App\Contracts\HasAssetsInterface;
use App\Models\VendorBranches\VendorBranch;
use App\Traits\HasAssetsTrait;
use App\Traits\Loggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;
use Astrotomic\Translatable\Translatable;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use App\Models\ActivityLog;
use App\Models\VendorPackage;

class Vendor extends Model implements HasAssetsInterface
{
    use HasFactory, Uuid, HasAssetsTrait, Loggable, Translatable;

    #region properties
    const TYPES = ['company', 'institution', 'member', 'freelance_doc', 'famous', 'other'];
    public $assets = ['logo', 'commercial_record_image', 'tax_number_image'];
    protected $guarded = ['created_at'];
    public $translatedAttributes = ['name'];
    private $sortableColumns = ["commercial_record", "is_active", "tax_number", "name", "type", "is_active"];

    #endregion properties
    public static function boot()
    {
        parent::boot();
        static::saved(function ($model) {
            $model->saveAssets($model, request());
        });
    }
    #region mutators
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
        if (isset($request->type) && in_array($request->type, self::TYPES))
            $query->where('type', 'like', "%$request->type%");
        if (isset($request->is_active) && in_array($request->is_active, [0, 1]))
            $query->where('is_active', $request->is_active);

        $new = $query->toSql();
        if ($old != $new) $this->addGlobalActivity($this, $request->query(), ActivityLog::SEARCH, 'index');
    }

    public function scopeSortBy(Builder $query, $request)
    {
        if (!isset($request->sort["column"]) || !isset($request->sort["dir"])) return $query->latest('created_at');

        if (
            !in_array(Str::lower($request->sort["column"]), $this->sortableColumns) ||
            !in_array(Str::lower($request->sort["dir"]), ["asc", "desc"])
        ) {
            return $query->latest('created_at');
        }


        $query->when($request->sort, function ($q) use ($request) {
            if ($request->sort["column"] == "name") {
                return $q->has('translations')
                    ->orderByTranslation($request->sort["column"], @$request->sort["dir"]);
            }

            if ($request->sort["column"] == "is_active") {
                $q->orderBy($request->sort["column"], @$request->sort["dir"]);
            }
            if ($request->sort["column"] == "commercial_record") {
                $q->orderBy($request->sort["column"], @$request->sort["dir"]);
            }

            if ($request->sort["column"] == "tax_number") {
                $q->orderBy($request->sort["column"], @$request->sort["dir"]);
            }
            if ($request->sort["column"] == "type") {
                $q->orderBy($request->sort["column"], @$request->sort["dir"]);
            }

            $q->orderBy($request->sort["column"], @$request->sort["dir"]);
        });
    }
    #endregion scopes

    #region relationships
    public function branches()
    {
        return $this->hasMany(VendorBranch::class);
    }

    public function package()
    {
        return $this->hasOne(VendorPackage::class, 'vendor_id');
    }
    #endregion relationships

    #region custom Methods
    #endregion custom Methods
}
