<?php

namespace App\Models\TransferPurpose;

use App\Models\ActivityLog;
use App\Traits\Loggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;
use Astrotomic\Translatable\Translatable;
use App\Models\BankTransfer;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class TransferPurpose extends Model
{
    use HasFactory, Uuid, Translatable, Loggable;

    #region properties
    public $translatedAttributes = ['name','description'];
    protected $attributes = ['is_active' => true];
    protected $guarded = ['created_at','updated_at','deleted_at'];
    private $sortableColumns = [ 'name','is_active',];
    public $with = ['translations'];
    #endregion properties

    #region mutators

    public function setIsDefaultValueAttribute($value)
    {
        if($value){
            self::where('id','<>',$this->id)->where('is_default_value',1)->update(['is_default_value' => 0]);
        }
        $this->attributes['is_default_value'] = $value;

    }

    #endregion mutators

    #region scopes
    public function scopeSearch(Builder $query, Request $request)
    {
        $old = $query->toSql();
        if ($request->has('name'))
            $query->whereTranslationLike('name', "%$request->name%");

        if ($request->has('is_active') && !in_array($request->is_active, [-1]))
            $query->where('is_active', $request->is_active);

        $new = $query->toSql();
        if ($old != $new || $request->is_active == -1) Loggable::addGlobalActivity($this, array_merge($request->query(), $this->searchParams($request)), ActivityLog::SEARCH, 'index');
    }

    public function scopeSortBy(Builder $query, $request)
    {
        if (!isset($request->sort["column"]) || !isset($request->sort["dir"])) return $query->latest('transfer_purposes.created_at');

        if (
            !in_array(\Str::lower($request->sort["column"]), $this->sortableColumns) ||
            !in_array(\Str::lower($request->sort["dir"]), ["asc", "desc"])
        ) {
            return $query->latest('transfer_purposes.created_at');
        }
        $query->when($request->sort, function ($q) use ($request) {
            if ($request->sort["column"]  == "name") {
                return $q->has('translations')
                    ->orderByTranslation($request->sort["column"], @$request->sort["dir"])->latest();
            }
            if ($request->sort["column"] == "is_active") {
                $q->orderBy($request->sort["column"], @$request->sort["dir"])->latest();
            }
            $q->orderBy($request->sort["column"], @$request->sort["dir"])->latest();
        });
    }

    public function scopeActive()
    {
        return $this->where('is_active', true);
    }
    #endregion scopes

    #region relationships
    public function bankTransfer()
    {
        return $this->hasMany(BankTransfer::class);
    }
    #endregion relationships

    #region custom Methods

    private function searchParams($request){
        $searchParams = [];
        if($request->has('is_active')){
            $searchParams['is_active'] = __('dashboard.transfer_purposes.active_cases.'. $request->is_active);
        }

        return $searchParams;
    }
    #endregion custom Methods
}
