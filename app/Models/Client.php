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
    public function scopeSearch($query, $request)
    {
        $query->whereHas('user', function ($q) use ($request) {
            $q->search($request);
        });

        if ($request->client_type) $query->where("client_type", $request->client_type);
        if ($request->nationality) $query->where("nationality", $request->nationality);
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
