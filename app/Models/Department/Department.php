<?php

namespace App\Models\Department;

use App\Contracts\HasAssetsInterface;
use App\Traits\HasAssetsTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\SoftDeletes;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;


class Department extends Model implements TranslatableContract, HasAssetsInterface
{
    use HasFactory, Uuid, HasAssetsTrait;
    use Translatable;
    use SoftDeletes;
    #region properties

    #region properties
    protected $guarded = ['created_at', 'updated_at', 'deleted_at'];
    public $translatedAttributes = ['name', 'description'];
    public $assets = ["image"];
    #endregion properties

    public static function boot()
    {
        parent::boot();
        static::saved(function ($model) {
            $request = app(\Illuminate\Http\Request::class);
            $model->saveAssets($model, $request);
        });
    }
    #region mutators
    #endregion mutators

    #region scopes
    #endregion scopes

    #region relationships
    public function parent()
    {
        return $this->belongsTo(Department::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Department::class, 'parent_id')->with("children");
    }
    #endregion relationships

    #region custom Methods
    #endregion custom Methods
}
