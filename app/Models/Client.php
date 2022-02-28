<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;
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
    public function scopeSearch(\Illuminate\Database\Eloquent\Builder $builder , $query)
    {
        if (isset($request->fullname)) {
            $query->where("fullname", "like", "%$request->fullname%");
        }

        if (isset($request->created_at)) {

            $query->whereDate('created_at', $request->created_at);
        }

        if (isset($request->client_type)) {
            $query->where("client_type", $request->client_type);
        }

        if (isset($request->country_id)) {
            $query->where('country_id', $request->country);
        }
        if (isset($request->is_ban)) {
            $query->where('is_ban', $request->is_ban);
        }
        if (isset($request->register_status)) {
            $query->where('register_status', $request->register_status);
        }
        if (isset($request->gender)) {
            $query->where('gender', $request->gender);
        }
        if (isset($request->is_active)) {
            $query->where('is_active', $request->is_active);
        }
        if (isset($request->is_admin_active_user)) {
            $query->where('is_admin_active_user', $request->is_admin_active_user);
        }
    }
    #endregion scopes

    #region relationships
    public function manager()
    {
        return $this->belongsTo(Manager::class);
    }
    #endregion relationships

    #region custom Methods
    #endregion custom Methods
}
