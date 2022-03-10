<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Uuid;

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
