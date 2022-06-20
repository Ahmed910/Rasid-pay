<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Builder;

class ClientPackageView extends Model
{
    use HasFactory, Uuid;

    #region properties
    public $table = "client_package_view";
    #endregion properties

    #region mutators
    #endregion mutators

    #region scopes
    public function scopeSearch(Builder $query, $request)
    {
        if ($request->client_id && !in_array($request->client_id, [-1])) {
            $query->where('id', "$request->client_id");
        }
    }

    public function scopeSortBy(Builder $query, $request)
    {
        if (isset($request->sort['column']) && in_array($request->sort['column'], ['palatinum_discount', 'basic_discount', 'golden_discount', 'fullname'])) {

            if ($request->sort['column'] == 'fullname')
                return $query->orderBy('name', @$request->sort['dir']);

            $query->orderBy($request->sort['column'], $request->sort['dir'] ?? 'asc');
        }
    }
    #endregion scopes

    #region relationships
    #endregion relationships

    #region custom Methods
    #endregion custom Methods
}
