<?php

namespace App\Models\MessageType;

use App\Models\ActivityLog;
use App\Models\Contact;
use App\Models\User;
use App\Traits\Loggable;
use App\Traits\Uuid;
use Astrotomic\Translatable\Translatable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class MessageType extends Model
{
    use HasFactory, Uuid, Loggable, Translatable;

    #region properties
    protected $guarded = ['created_at'];
    public $translatedAttributes = ['name'];
    private $sortableColumns = ['name', 'employee_count', 'created_at', 'is_active'];
    public $with = ['translations'];
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

        if (isset($request->is_active) && in_array($request->is_active, [1, 0])) {
            $query->where('is_active', $request->is_active);
        }

        if ($request->employee_list) {
            $query->whereHas("admins", function ($q) use ($request) {
                $q->whereIn('admin_id', $request->employee_list);
            });
        }


        $new = $query->toSql();
        if ($old != $new) Loggable::addGlobalActivity($this, array_merge(
            $request->query(),
            ['employee_list' => User::find($request->employee_list)?->pluck('fullname')]
        ), ActivityLog::SEARCH, 'index');
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
                return $q->withCount('admins')->orderBy('admins_count', @$request->sort["dir"]);
            }

            $q->orderBy($request->sort["column"], @$request->sort["dir"]);
        });
    }

    #endregion scopes

    #region relationships
    public function admins(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'message_type_user', 'message_type_id', 'admin_id');
    }
    public function contact()
    {
        return $this->hasMany(Contact::class, 'message_type_id');
    }

    #endregion relationships

    #region custom Methods
    #endregion custom Methods
}
