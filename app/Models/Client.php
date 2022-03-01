<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;

class Client extends Model
{
    use HasFactory, Uuid;

    #region properties
    protected $guarded = ['created_at', 'updated_at'];
    protected $dates = ['date_of_birth'];
    #endregion properties

    #region mutators
    #endregion mutators

    #region scopes
    public function scopeSearch(\Illuminate\Database\Eloquent\Builder $query, $request)
    {
        $query->whereHas('user', function ($q) use ($request) {
            if (isset($request->fullname)) $q->where('fullname', "like", "%$request->fullname%");
            if (isset($request->ban_status)) $q->where('ban_status', $request->ban_status);
            if (isset($request->gender)) $q->where('gender', $request->gender);
            if (isset($request->register_status)) $q->where('register_status', $request->register_status);
            if (isset($request->is_active)) $q->where('is_active', $request->is_active);

        });

        if (isset($request->created_at)) {

            $query->whereDate('created_at', $request->created_at);
        }

        if (isset($request->client_type)) {
            $query->where("client_type", $request->client_type);
        }

        if (isset($request->nationality)) {
            $query->where("nationality", $request->nationality);
        }
    }
    #endregion scopes

    #region relationships
    public function manager()
    {
        return $this->belongsTo(Manager::class);
    }

    public function user()
    {
        return $this->belongsTo(user::class);
    }
    #endregion relationships

    #region custom Methods
    #endregion custom Methods
}
