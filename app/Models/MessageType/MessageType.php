<?php

namespace App\Models\MessageType;

use App\Models\ActivityLog;
use App\Models\User;
use App\Traits\Loggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class MessageType extends Model
{
    use HasFactory, Uuid, Loggable, Translatable;

    #region properties
    protected $guarded = ['created_at'];
    public $translatedAttributes = ['name'];
    private $sortableColumns = ['name', 'employee', 'created_at'];
    #endregion properties

    #region mutators
    #endregion mutators

    #region scopes
    public function scopeSearch(Builder $query, $request)
    {
        $old = $query->toSql();

        if ($request->name) {
            $query->where(function ($q) use ($request) {
                $q->whereTranslationLike('name', "%\\$request->name%");
            });
        }

        //employee_count
        // if ($request->employee_id) {
        //     if (!is_array($request->employee_id))
        //         $employeeIds = Arr::wrap($request->employee);

        //     if (!in_array(-1, $employeeIds))  $query->employees()->whereIn("employee_id", $employeeIds);
        // }

        if ($request->employee_id) $query->whereHas("admins", function ($q) use ($request) {
            if (!is_array($request->employee_id))
                 $adminsIDs = Arr::wrap($request->employee_id);
                 
            if (!in_array(-1, $adminsIDs)) 
                $q->whereIn('admin_id', $adminsIDs);
        });


        $new = $query->toSql();
        if ($old != $new)  $this->addGlobalActivity($this, $request->query(), ActivityLog::SEARCH, 'index');
    }

    public function scopeSortBy(Builder $query, $request)
    {
        if (!isset($request->sort["column"]) || !isset($request->sort["dir"])) return $query->latest('message_types.created_at');

        if (
            !in_array(Str::lower($request->sort["column"]), $this->sortableColumns) ||
            !in_array(Str::lower($request->sort["dir"]), ["asc", "desc"])
        ) {
            return $query->latest('message_types.created_at');
        }

        $query->when($request->sort, function ($q) use ($request) {
            if ($request->sort["column"] == "name") {
                return $q->has('translations')
                    ->orderBy($request->sort["column"], @$request->sort["dir"]);
            }

            if ($request->sort["column"] == "employee_count") {
                return $q->withCount('admins')->orderBy('admins_count');
            }

            $q->orderBy($request->sort["column"], @$request->sort["dir"]);
        });
    }
    #endregion scopes

    #region relationships
    public function admins(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'message_type_user','message_type_id','admin_id');
    }
    #endregion relationships

    #region custom Methods
    #endregion custom Methods
}
