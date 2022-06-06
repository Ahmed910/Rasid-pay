<?php

namespace App\Models\Group;

use App\Models\{ActivityLog, Permission, User};
use App\Traits\{Loggable, Uuid};
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class Group extends Model implements TranslatableContract
{
    use HasFactory, Translatable, Uuid, Loggable;

    #region properties
    protected $guarded = ["created_at"];
    public $translatedAttributes = ['name'];
    public $attributes = ['is_active' => true];
    private $sortableColumns = ['name', 'admins_count', 'is_active','created_at'];
    #endregion properties

    #region mutators
    #endregion mutators

    #region scopes
    public function scopeSearch($query, $request)
    {
        $old = $query->toSql() ;

        if (isset($request->name)) {
            $query->whereTranslationLike('name',"%$request->name%");
        }

        if (isset($request->is_active)) {
            if (!in_array($request->is_active, [1, 0])) return;

            $query->where('is_active', $request->is_active);
        }

        if (!is_null($request->admins_from) && $request->admins_from >= 0) {
            $query->having('user_count',">=" , (int)$request->admins_from);
        }

        if (!is_null($request->admins_to) && $request->admins_to >= 0) {
            $query->having('user_count',"<=" , (int)$request->admins_to);
        }
        $new = $query->toSql() ;
        if ($old!=$new)  $this->addGlobalActivity($this, $request->query(), ActivityLog::SEARCH, 'index');
    }

    public function scopeActive($query)
    {
        $query->where('is_active',true);
    }

    public function scopeSortBy(Builder $query,$request)
    {

        if (!isset($request->sort["column"]) || !isset($request->sort["dir"])) return $query->latest('created_at');

        if (
            !in_array(Str::lower($request->sort["column"]), $this->sortableColumns) ||
            !in_array(Str::lower($request->sort["dir"]), ["asc", "desc"])
        ) {
            return $query->latest('created_at');
        }


        $query->when($request->sort, function ($q) use ($request) {
            if ($request->sort["column"]  == "name") {
                return $q->join('group_translations','group_translations.group_id','groups.id')
                    ->orderBy($request->sort["column"], @$request->sort["dir"]);
            }
            if($request->sort["column"]  == "admins_count")
            {
                return $q->withCount('admins')->orderBy('admins_count', @$request->sort["dir"]);
            }

            $q->orderBy($request->sort["column"], @$request->sort["dir"]);
        });


    }
    #endregion scopes

    #region relationships
    public function admins()
    {
        return $this->belongsToMany(User::class);
    }

    public function addedBy()
    {
        return $this->belongsTo(User::class,'added_by_id');
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    public function groups()
    {
        return $this->belongsToMany(self::class, 'pivot_group', 'first_group_id', 'second_group_id');
    }
    #endregion relationships

    #region custom Methods
    public function getPermissionListAttribute()
    {
        return $this->permissions->pluck('id')->toArray();
    }

    public function getGroupListAttribute()
    {
        return $this->groups->pluck('id')->toArray();
    }

    public static function getGroupPermissions(self $group)
    {
        foreach ($group->permissions as $permission) {
            $permissionObj = explode('.', $permission->name);
            $single_uri = str_singular($permissionObj[0]);
            $main_prog = trans('dashboard.' . $single_uri . '.' . $permissionObj[0]);
            $action = trans('dashboard.' . $single_uri . '.permissions.' . @$permissionObj[1]);
            $sub_prog = '---';

            switch ($permissionObj) {
                case in_array(@$permissionObj[1], ['update', 'show', 'destroy']):
                    $sub_prog = trans('dashboard.' . $single_uri . '.sub_progs.index');
                    break;
                case in_array(@$permissionObj[1], ['restore', 'force_delete']):
                    $sub_prog = trans('dashboard.' . $single_uri . '.sub_progs.archive');
                    break;
            }

            $groupData[] = [
                'id' => $permission->id,
                'is_selected' => auth()->user()->permissions()->where('permissions.id',$permission->id)->exists(),
                'main_prog' => $main_prog,
                'sub_prog' => $sub_prog,
                'action' => $action,
                'uri' => $permission->name,
                'name' => $main_prog . ' (' . $action . ')',
                'created_at' => $permission->created_at
            ];
        }

        return $groupData;
    }
    #endregion custom Methods
}
