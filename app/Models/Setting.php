<?php

namespace App\Models;

use App\Traits\Loggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;

class Setting extends Model
{
    use HasFactory, Uuid, Loggable;

    protected $guarded = ['created_at','deleted_at'];
    protected $casts   = ['value' => 'array'];

    const TEXT_AREA = "textarea";
    const EDITOR    = "editor";
    const TEXT      = "text";
    const FILE      = "file";
    const NUMBER    = "number";

    const TYPES = [
        self::TEXT_AREA,
        self::EDITOR,
        self::TEXT,
        self::FILE,
        self::NUMBER
    ];

    const ERP = "erp";
    const RASID_PAY = "rasid_pay";

    const DASHBOARD_TYPES = [
        self::ERP,
        self::RASID_PAY
    ];
}
