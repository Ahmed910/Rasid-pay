<?php

namespace App\Models;

use App\Models\Vendor\Vendor;
use App\Traits\Loggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Builder;

class VendorPackage extends Model
{
    use HasFactory, Uuid, Loggable;

    #region properties
    protected $guarded = ['created_at', 'updated_at'];
    protected $attributes = ['basic_discount' => 0, 'golden_discount' => 0,'platinum_discount' => 0];
    #endregion properties

    #region mutators
    #endregion mutators

    #region scopes
    public function scopeSearch(Builder $query, $request)
    {
        if ($request->client_id && !in_array($request->client_id, [-1])) {
            $query->where('vendor_id', "$request->client_id");
        }
    }

    public function scopeSortBy(Builder $query, $request)
    {
        if (isset($request->sort['column']) && in_array($request->sort['column'], ['platinum_discount', 'basic_discount', 'golden_discount', 'fullname'])) {

            if ($request->sort['column'] == 'fullname')
                return $query->join('vendor_translations', 'vendor_packages.vendor_id', 'vendor_translations.vendor_id')
                    ->orderBy('name', @$request->sort['dir']);

            $query->orderBy($request->sort['column'], $request->sort['dir'] ?? 'asc');
        }
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
