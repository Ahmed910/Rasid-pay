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
    private $sortableColumns = ['question','order','is_active'];
    public $with = ['translations'];
    #endregion properties


    #region mutators
    #endregion mutators

    #region scopes
    public function scopeSearch(Builder $query, $request)
    {
        $old = $query->toSql() ;

        if (isset($request->question)) {
            $query->where(function ($q) use ($request) {
                $q->whereTranslationLike('question', "%$request->question%");
            });
        }
        if (isset($request->is_active) && in_array($request->is_active, [1, 0])) {
            $query->where('is_active', $request->is_active);
        }
        $new = $query->toSql() ;
        if ($old!=$new || $request->is_active == -1 )  Loggable::addGlobalActivity($this, array_merge($request->query(), $this->searchParams($request)), ActivityLog::SEARCH, 'index');

    }

    public function scopeSortBy(Builder $query, $request)
    {

        if (!isset($request->sort["column"]) || !isset($request->sort["dir"])) return $query->orderBy('faqs.order')->oldest();

        if (
            !in_array(Str::lower($request->sort["column"]), $this->sortableColumns) ||
            !in_array(Str::lower($request->sort["dir"]), ["asc", "answer"])
        ) {
            return $query->orderBy('faqs.order')->oldest();
        }

        $query->when($request->sort, function ($q) use ($request) {
            if ($request->sort["column"] == "question") {
                return $q->orderByTranslation($request->sort["column"], @$request->sort["dir"])->oldest();
            }
            if ($request->sort["column"] == "is_active") {
                return $q->orderBy('is_active', $request->sort['dir'])->oldest();
            }

            $q->orderBy($request->sort["column"], @$request->sort["dir"])->oldest();
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
    private function searchParams($request){
        $searchParams = [];
        if($request->has('is_active')){
            $searchParams['is_active'] = __('dashboard.faq.active_cases.'. $request->is_active);
        }

        return $searchParams;
    }
    #endregion custom Methods
}
