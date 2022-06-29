<?php

namespace App\Models\Faq;

use App\Models\User;
use App\Traits\Loggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Illuminate\Database\Eloquent\Builder;
use Astrotomic\Translatable\Translatable;
use App\Models\ActivityLog;
use Illuminate\Support\Str;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Faq extends Model implements TranslatableContract
{
    use HasFactory, Uuid, Translatable, Loggable;


    #region properties
    protected $guarded = ['created_at'];
    public $translatedAttributes = ['question', 'answer'];

    #endregion properties


    #region mutators
    #endregion mutators

    #region scopes
    public function scopeSearch(Builder $query, $request)
    {
        $old = $query->toSql() ;

        if (isset($request->question)) {
            $query->where(function ($q) use ($request) {
                $q->whereTranslationLike('name', "%$request->question%");
            });
        }
        if (isset($request->is_active) && in_array($request->is_active, [1, 0])) {
            $query->where('is_active', $request->is_active);
        }
        $new = $query->toSql() ;
        if ($old!=$new)  $this->addGlobalActivity($this, $request->query(), ActivityLog::SEARCH, 'index');

    }

    public function scopeSortBy(Builder $query, $request)
    {

        if (!isset($request->sort["column"]) || !isset($request->sort["dir"])) return $query->orderBy('faqs.order');

        if (
            !in_array(Str::lower($request->sort["column"]), $this->sortableColumns) ||
            !in_array(Str::lower($request->sort["dir"]), ["asc", "answer"])
        ) {
            return $query->orderBy('faqs.order');
        }

        $query->when($request->sort, function ($q) use ($request) {
            if ($request->sort["column"] == "question") {
                return $q->has('translations')
                    ->orderBy($request->sort["column"], @$request->sort["dir"]);
            }
            if ($request->sort["column"] == "is_active") {
                return $q->orderBy('is_active', $request->sort['dir']);
            }

            $q->orderBy($request->sort["column"], @$request->sort["dir"]);
        });
    }

    #endregion scopes

    #region relationships
    public function addedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'added_by_id');
    }
    #endregion relationships

    #region custom Methods
    #endregion custom Methods
}
