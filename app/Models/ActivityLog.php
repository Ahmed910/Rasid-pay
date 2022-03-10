<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Builder;

class ActivityLog extends Model
{
    use HasFactory, SoftDeletes, Uuid;

    #region properties
    protected $guarded = ['created_at', 'updated_at', 'deleted_at'];
    protected $table = 'activity_logs';
    protected $with = ['user', 'auditable'];
    protected $casts = ["new_data" => "array", "old_data" => "array", 'search_params' => 'array'];

    const CREATE           = 'created';
    const UPDATE           = 'updated';
    const DESTROY          = 'destroy';
    const RESTORE          = 'restored';
    const PERMANENT_DELETE = 'permanent_delete';
    const SEARCH           = 'searched';

    const EVENTS = [
        self::CREATE,
        self::UPDATE,
        self::DESTROY,
        self::RESTORE,
        self::PERMANENT_DELETE,
        self::SEARCH
    ];
    #endregion properties

    #region mutators
    #endregion mutators

    #region scopes
    public function scopeSearch(Builder $query, $request)
    {
        if ($request->action) {
            $query->where('action_type', $request->action);
        }

        if ($request->employee_id) {
            $query->where('user_id', $request->employee_id);
        }

        if ($request->department_id) {
            $query->whereHas('user.employee.department', function ($q) use ($request) {
                $q->where('id', $request->department_id)->toSql();
            });
        }

        if ($request->main_program) {
            $query->where('auditable_type', $request->main_program);
        }

        if ($request->sub_program) {
            $query->where('sub_program', $request->sub_program);
        }
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
