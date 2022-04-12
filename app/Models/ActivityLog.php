<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Uuid;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class ActivityLog extends Model
{
    use HasFactory, SoftDeletes, Uuid;

    #region properties
    protected $guarded = ['created_at', 'updated_at', 'deleted_at'];
    protected $table = 'activity_logs';
    protected $with = ['user', 'auditable'];
    protected $casts = ["new_data" => "array", "old_data" => "array", 'search_params' => 'array'];
    private $sortableColumns = ['employee', 'department', 'main_program', 'sub_program', 'created_at', 'ip_address', 'action_type'];

    const CREATE = 'created';
    const UPDATE = 'updated';
    const DESTROY = 'destroy';
    const RESTORE = 'restored';
    const PERMANENT_DELETE = 'permanent_delete';
    const SEARCH = 'searched';
    const DEACTIVE = 'deactivated';
    const ACTIVE = 'activated';
    const PERMANENT = 'permanent';
    const TEMPORARY = 'temporary';

    const EVENTS = [
        self::CREATE,
        self::UPDATE,
        self::DESTROY,
        self::RESTORE,
        self::PERMANENT_DELETE,
        self::SEARCH,
        self::DEACTIVE,
        self::ACTIVE,
        self::PERMANENT,
        self::TEMPORARY
    ];
    #endregion properties

    #region mutators
    #endregion mutators

    #region accessor

    #endregion accessor

    #region scopes
    public function scopeSearch(Builder $query, $request)
    {

        if (isset($request->action) && in_array($request->action, [1, 0])) {
            $query->where('action_type', $request->action);
        }

        if ($request->employee_id) {
            $query->where('user_id', $request->employee_id);
        }

        if (isset($request->department_id) && $request->department_id != 0) {
            $query->whereHas('user.employee.department', function ($q) use ($request) {
                $q->where('id', $request->department_id);
            });
        }

        if (isset($request->main_program) && in_array($request->main_program, [1, 0])) {
            $query->where('auditable_type', $request->main_program);
        }
        
        if (isset($request->sub_program) && in_array($request->sub_program, [1, 0])) {
            $query->where('sub_program', $request->sub_program);
        }

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
            // TODO:: Refactoring employee and department sorting
            if ($request->sort["column"] == "employee") {
                return $q->leftjoin('users', 'activity_logs.user_id', 'users.id')
                    ->orderBy('users.fullname');
            }

            if ($request->sort["column"] == "main_program") {
                return $q->orderBy('auditable_type', @$request->sort["dir"]);
            }

            if ($request->sort["column"] == "department") {
                return $q->leftJoin('users', 'users.id', 'activity_logs.user_id')
                    ->leftJoin('employees', 'employees.user_id', 'users.id')
                    ->leftJoin('departments', 'departments.id', 'employees.department_id')
                    ->leftJoin('department_translations', 'department_translations.department_id', 'departments.id')
                    ->orderBy('department_translations.name');
            }

            $q->orderBy($request->sort["column"], @$request->sort["dir"]);
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
        return $this->morphTo();
    }
    #endregion relationships


    #region custom Methods
    #endregion custom Methods
}
