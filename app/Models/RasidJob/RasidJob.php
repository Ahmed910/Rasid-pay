<?php

namespace App\Models\RasidJob;

use App\Models\ActivityLog;
use App\Models\User;
use App\Traits\Uuid;
use App\Traits\Loggable;
use App\Models\Department\Department;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Carbon\Carbon;

class RasidJob extends Model implements TranslatableContract
{
    use HasFactory, Uuid, Translatable, SoftDeletes, Loggable;

    #region properties
    protected $guarded = ['created_at', 'deleted_at'];
    public $translatedAttributes = ['name', 'description'];
    public $attributes = ['is_active' => true, 'is_vacant' =>  true];
    protected $with = ['translations', 'addedBy', 'department', 'employee'];
    private $sortableColumns = ["name", "department", "created_at", "is_active", "is_vacant", 'deleted_at'];

    #endregion properties

    #region mutators

    public function setAddedByIdAttribute($value)
    {
        $this->attributes['added_by_id'] = $value ? $value : null;
    }
    #endregion mutators

    #region accessor

    #endregion accessor

    #region scopes
    public function scopeSearch(Builder $query, $request)
    {
        $old = $query->toSql() ;

        if (isset($request->name)) {
            $query->where(function ($q) use ($request) {
                $q->whereTranslationLike('name', "%$request->name%");
            });
        }

        if (isset($request->department_id) && !in_array($request->department_id, [-1])) {
            $query->where("department_id", $request->department_id);
        }

        if (isset($request->is_active) && in_array($request->is_active, [1, 0])) {
            $query->where('is_active', $request->is_active);
        }

        if (isset($request->is_vacant) && in_array($request->is_vacant, [1, 0])) {
            $query->where('is_vacant', $request->is_vacant);
        }
        $new = $query->toSql();
       
        if ($old!=$new | $request->is_active == -1 || $request->is_vacant == -1)  Loggable::addGlobalActivity($this, array_merge($request->query(), $this->searchParams($request) ), ActivityLog::SEARCH, 'index');
    
    }

    public function scopeSortBy(Builder $query, $request,$type=null)
    {

        if (!isset($request->sort["column"]) || !isset($request->sort["dir"])) return $query->latest('rasid_jobs.created_at');

        if (
            !in_array(Str::lower($request->sort["column"]), $this->sortableColumns) ||
            !in_array(Str::lower($request->sort["dir"]), ["asc", "desc"])
        ) {
        if($type == 'archive')
        {
            return $query->latest('rasid_jobs.deleted_at');
        }
            return $query->latest('rasid_jobs.created_at');
        }

        $query->when($request->sort, function ($q) use ($request) {
            if ($request->sort["column"] == "name") {
                return $q->has('translations')
                    ->orderBy($request->sort["column"], @$request->sort["dir"])->latest();
            }

            if ($request->sort["column"] == "department") {
                return $q->join('departments as department', 'rasid_jobs.department_id', '=', 'department.id')
                    ->leftJoin('department_translations as department_trans', 'department.id', '=', 'department_trans.department_id')
                    ->orderBy('department_trans.name', @$request->sort["dir"])->latest();

                }

            $q->orderBy($request->sort["column"], @$request->sort["dir"])->latest();
        });
    }

    #endregion scopes

    #region relationships
    public function department()
    {
        return $this->belongsTo(Department::class);
    }


    public function addedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'added_by_id');
    }

    public function employee()
    {
        return $this->hasOne(Employee::class, 'rasid_job_id', 'id');
    }

    #endregion relationships

    #region custom Methods
    private function searchParams($request){
        $searchParams = [];
        if($request->has('is_active')){
            $searchParams['is_active'] = __('dashboard.rasid_job.active_cases.'. $request->is_active);
        }
        if($request->has('is_vacant')){
            $searchParams['is_vacant'] = __('dashboard.rasid_job.job_type.'. $request->is_vacant);
        }
        if($request->department_id){
        }
        if($request->has('department_id') && $request->department_id == null){
            $searchParams['department_id'] = __('dashboard.rasid_job.department.all');
        }elseif($request->has('department_id')){
            $searchParams['department_id'] = Department::find($request->department_id)?->name;
        }
        return $searchParams;
    }
    #endregion custom Methods
}
