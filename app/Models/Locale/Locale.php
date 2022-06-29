<?php

namespace App\Models\Locale;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class Locale extends Model
{
    use HasFactory, Uuid, Translatable;

    #region properties
    protected $guarded = ["created_at", "created_at"];
    protected $with = ["translations"];
    public $translatedAttributes = ['value', 'desc'];
    private $sortableColumns = ["key", "value"];
    #endregion properties

    #region mutators
    #endregion mutators

    #region scopes
    public function scopeSearch(Builder $query, Request $request)
    {
        if ($request->key)  $query->where('key', 'like', "%$request->key%");
        if ($request->value) $query->whereHas('translations', fn ($q) => $q->where('value', 'like', "%$request->value%"));
    }

    public function scopeSortBy(Builder $query, Request $request)
    {
        if (!isset($request->sort["column"]) || !isset($request->sort["dir"])) return $query->latest('locales.created_at');

        if (
            !in_array(Str::lower($request->sort["column"]), $this->sortableColumns) ||
            !in_array(Str::lower($request->sort["dir"]), ["asc", "desc"])
        ) {
            return $query->latest('locales.created_at');
        }

        $query->when($request->sort, function ($q) use ($request) {
            if ($request->sort["column"] == "value") {
                return $q->orderByTranslation($request->sort["column"], @$request->sort["dir"]);
            }

            $q->orderBy($request->sort["column"], @$request->sort["dir"]);
        });
    }
    #endregion scopes

    #region relationships
    #endregion relationships

    #region custom Methods
    #endregion custom Methods
}
