<?php

namespace App\Models\Locale;

use App\Models\ActivityLog;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;
use App\Traits\Loggable;
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
        $old = $query->toSql();

        if ($request->key)  $query->where('key', 'like', "%$request->key%");
        if ($request->value) $query->whereHas('translations', fn ($q) => $q->where('value', 'like', "%$request->value%"));

        $new = $query->toSql();
        if ($old != $new) Loggable::addGlobalActivity($this, $request->query(), ActivityLog::SEARCH, 'index');
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
                return $q->has('translations')
                    ->orderBy($request->sort["column"], @$request->sort["dir"])->latest();
            }

            $q->orderBy($request->sort["column"], @$request->sort["dir"])->latest();
        });
    }
    #endregion scopes

    #region relationships
    #endregion relationships

    #region custom Methods
    #endregion custom Methods
}
