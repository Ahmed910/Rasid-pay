<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\User;
use App\Traits\Uuid;
use App\Traits\Loggable;
use Illuminate\Support\Str;
use App\Models\Department\Department;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use GeniusTS\HijriDate\{Date, Hijri, Translations\Arabic, Translations\English};

class ActivityLog extends Model
{
    use HasFactory, SoftDeletes, Uuid;

    #region properties
    protected $guarded = ['created_at', 'updated_at', 'deleted_at'];
    protected $table = 'activity_logs';
    protected $with = ['user', 'auditable'];
    protected $casts = ["new_data" => "array", "old_data" => "array", 'search_params' => 'array'];
    private $sortableColumns = ['employee', 'department', 'main_program', 'sub_program', 'created_at', 'ip_address', 'action_type', 'reason'];

    const CREATE = 'created';
    const UPDATE = 'updated';
    const DESTROY = 'destroy';
    const DELETE = 'delete';
    const PERMANENT_DELETE = 'permanent_delete';
    const RESTORE = 'restored';
    const SEARCH = 'searched';
    const DEACTIVE = 'deactivated';
    const ACTIVE = 'activated';
    const PERMANENT = 'permanent';
    const TEMPORARY = 'temporary';
    const SHOWN = 'shown';
    const ASSIGNED = 'assigned';
    const REPLIED = 'replied';
    const EXPORT = 'export';

    const EVENTS = [
        self::CREATE,
        self::UPDATE,
        self::DESTROY,
        self::PERMANENT_DELETE,
        self::RESTORE,
        self::SEARCH,
        self::DEACTIVE,
        self::ACTIVE,
        self::PERMANENT,
        self::TEMPORARY,
        self::SHOWN,
        self::ASSIGNED,
        self::REPLIED,
        self::DELETE,
        self::EXPORT
    ];
    #endregion properties

    #region mutators
    public function setActionTypeAttribute($value)
    {
        $this->attributes['action_type'] = $value;
        $this->attributes['action_type_ar'] = trans('dashboard.activity_log.action_types.' . $value);
    }
    #endregion mutators

    #region accessor

    #endregion accessor

    #region scopes
    public function scopeSearch(Builder $query, $request)
    {
        $old = $query->toSql();

        if (isset($request->action) && !in_array($request->action, [-1])) {
            $query->where('action_type', $request->action);
        }

        if ($request->employee_list && is_array($request->employee_list) && !in_array(-1, $request->employee_list)) {
            $query->whereIn('user_id', $request->employee_list);
        }

        if ($request->has('department_list') && is_array($request->department_list) && !in_array(-1, $request->department_list)) {
            $query->whereHas('user.employee.department', function ($q) use ($request) {
                $q->whereIn('id', $request->department_list);
            });
        }


        if (isset($request->main_program) && !in_array($request->main_program, [-1])) {
            if ($request->main_program == 'UserCitizen') {
                return $query->where('auditable_type', $request->main_program)
                    ->where('user_type', 'citizen');
            }
            $query->where('auditable_type', $request->main_program);
        }

        if (isset($request->sub_program) && !in_array($request->sub_program, [-1])) {
            $query->where('sub_program', $request->sub_program);
        }

        $new = $query->toSql();
        if ($old != $new || $request->action == -1)  Loggable::addGlobalActivity($this, array_merge($request->query(), $this->searchParams($request)), ActivityLog::SEARCH, 'index');
    }

    public function scopeSortBy(Builder $query, $request)
    {

        if (!isset($request->sort["column"]) || !isset($request->sort["dir"])) return $query->latest('activity_logs.created_at');

        if (
            !in_array(Str::lower($request->sort["column"]), $this->sortableColumns) ||
            !in_array(Str::lower($request->sort["dir"]), ["asc", "desc"])
        ) {
            return $query->latest('activity_logs.created_at');
        }


        $query->when($request->sort, function ($q) use ($request) {
            // TODO:: Refactoring employee and department sorting
            if ($request->sort["column"] == "employee") {
                return $q->leftjoin('users', 'activity_logs.user_id', 'users.id')
                    ->orderBy('users.fullname')->latest('activity_logs.created_at');
            }

            if ($request->sort["column"] == "main_program") {
                return $q->orderBy('auditable_type', @$request->sort["dir"])->latest('activity_logs.created_at');
            }
            if ($request->sort["column"] == "subprogram") {
                return $q->orderBy('sub_program', @$request->sort["dir"])->latest('activity_logs.created_at');
            }

            if ($request->sort["column"] == "department") {
                return $q->leftJoin('users', 'users.id', 'activity_logs.user_id')
                    ->leftJoin('employees', 'employees.user_id', 'users.id')
                    ->leftJoin('departments', 'departments.id', 'employees.department_id')
                    ->leftJoin('department_translations', 'department_translations.department_id', 'departments.id')
                    ->orderBy('department_translations.name')->latest('activity_logs.created_at');
            }

            if ($request->sort['column'] == 'action_type') {
                (app()->getLocale() == 'ar') ?
                    $q->orderBy('action_type_ar', @$request->sort["dir"])->latest('activity_logs.created_at') :
                    $q->orderBy('action_type', @$request->sort["dir"])->latest('activity_logs.created_at');
            }

            $q->orderBy($request->sort["column"], @$request->sort["dir"])->latest('activity_logs.created_at');
        });
    }
    #endregion scopes

    #region relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function auditable()
    {
        return $this->morphTo()->withTrashed();
    }
    #endregion relationships


    #region custom Methods
    public function searchParams($request)
    {
        $searchParams = [];

        if ($request->has('action')) {
            $searchParams['action'] = trans('dashboard.activity_log.actions.' . $request->action);
        }

        if ($request->has('department_list')) {
            $searchParams['department_list'] =  Department::find($request->department_list)?->pluck('name')->join(',');
        }

        if ($request->has('employee_list')) {
            $searchParams['employee_list'] =  User::find($request->employee_list)?->pluck('fullname')->join(',');
        }

        if ($request->has('main_program')) {
            $searchParams['main_program'] =  trans("dashboard." . Str::snake($request->main_program) . "." . str_plural(Str::snake($request->main_program)));
        }

        if ($request->has('sub_program')) {
            $searchParams['sub_program'] =  trans('dashboard.sub_progs.' . $request->sub_program);
        }

        return $searchParams;
    }
    #endregion custom Methods
}
