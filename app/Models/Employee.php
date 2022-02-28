<?php

namespace App\Models;

use App\Models\Department\Department;
use App\Models\RasidJob\RasidJob;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;

class Employee extends Model
{
    use HasFactory, Uuid;

    protected $guarded = ['created_at', 'updated_at'];


    #region properties
    #endregion properties

    #region mutators
    #endregion mutators

    #region scopes
    #endregion scopes

    #region relationships
    #endregion relationships

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function job()
    {
        return $this->belongsTo(RasidJob::class);
    }




    #region custom Methods
    #endregion custom Methods
}
