<?php

namespace App\Models;

use App\Traits\Uuid;
use App\Models\CardPackage\CardPackage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CitizenCard extends Model
{
    use HasFactory, Uuid;

    #region properties
    protected $table = 'citizen_cards';
    protected $guarded = ['created_at', 'updated_at'];
    protected $dates = ['start_at', 'end_at'];
    #endregion properties

    #region mutators
    #endregion mutators

    #region scopes
    public function setCardPackageIdAttribute($value){
        $this->attributes['card_package_id'] = $value;
        $this->attributes['card_data'] = CardPackage::select('id','price','offer','cash_back','promo_cash_back','discount_promo_code')->listsTranslations('name')->find($value)->toJson();

    }
    #endregion scopes

    #region relationships

    public function cardPackage()
    {
        return $this->belongsTo(CardPackage::class, 'card_package_id');
    }

   public function citizen()
    {
        return $this->belongsTo(User::class);
    }
    #endregion relationships

    #region custom Methods
    #endregion custom Methods
}
