<?php

namespace App\Models;

use App\Models\MessageType\MessageType;
use App\Traits\Loggable;
use App\Traits\Uuid;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Contact extends Model
{
    use HasFactory, Uuid, SoftDeletes, Loggable;

    #region properties
    protected $guarded = ['created_at', 'updated_at', 'deleted_at'];
    const ADMINCOLUMNS = ["admin_fullname" => "fullname"];
    const USER_COLUMNS = ["contact_type", "message_source", "message_status"];
    const SELECT_ALL = ["contact_type", "message_source", "message_status"];
    const PENDING = 'pending';
    const REPLIED = 'replied';
    const WAITING = 'waiting';
    const MESSAGE_STATUS = [self::PENDING, self::REPLIED, self::WAITING];
    #endregion properties

    #region mutators
    public function getReadAtAttribute($date)
    {
        return date('Y-m-d h:i A', strtotime($date));
    }

    public function setTitleAttribute($value)
    {
        if (auth('sanctum')->check()) {
            $this->attributes['fullname'] = auth('sanctum')->user()->fullname;
            $this->attributes['user_id'] = auth('sanctum')->id();
            $this->attributes['email'] = auth('sanctum')->user()->email;
            $this->attributes['phone'] = auth('sanctum')->user()->phone;
        }

        $this->attributes['title'] = $value;
    }

    public function getCreatedAtHumanAttribute($date)
    {
        return Carbon::parse($this->attributes['created_at'])->diffForHumans();
    }
    #endregion mutators

    #region scopes
    public function scopeSearch($query, $request)
    {

        foreach ($request->all() as $key => $item) {
            if ($item == -1 && in_array($key, self::SELECT_ALL)) {
                $request->request->remove($key);
                continue;
            }

            if (isset($request->fullname))
                $query->where('fullname', 'like', "%$request->fullname%");
            if (isset($request->email))
                $query->where('email', 'like', "%$request->email%");
            if (isset($request->phone))
                $query->where('phone', 'like', "%$request->phone%");

            if (in_array($key, self::USER_COLUMNS)) {
                $query->where('contacts.' . $key, $item);
            }

            if ($request->message_types && is_array($request->message_types)) {
                $query->whereIn('message_type_id', $request->message_types);
            }

            if (key_exists($key, self::ADMINCOLUMNS))
                $query->whereHas('admin', function ($q) use ($key, $item) {
                    $key = self::ADMINCOLUMNS[$key];
                    !($key == "fullname") ? $q->where($key, $item) : $q->where($key, "like", "%$item%");
                });
        }

    }

    public function scopeSortBy(Builder $query, $request)
    {
        if (!isset($request->sort["column"]) || !isset($request->sort["dir"])
            || !in_array(Str::lower($request->sort["dir"]), ["asc", "desc"])
        ) return $query->latest('contacts.created_at');


        if (in_array($request->sort["column"], self::USER_COLUMNS)) {
            return $query
                ->orderBy('contacts.' . $request->sort["column"], @$request->sort["dir"]);
        }
        if (key_exists($request->sort["column"], self::ADMINCOLUMNS)) {
            return $query->leftJoin('users', 'users.id', '=', 'contacts.admin_id')
                ->select("contacts.*", "users.fullname as admin.")
                ->orderBy('users.' . self::ADMINCOLUMNS[$request->sort["column"]], @$request->sort["dir"]);
        }

    }
    #endregion scopes

    #region relationships
    public function replies(): HasMany
    {
        return $this->hasMany(ContactReply::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function assignedTo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to_id');
    }

    public function messageType(): BelongsTo
    {
        return $this->belongsTo(MessageType::class, 'message_type_id');
    }
    #endregion relationships

    #region custom Methods
    #endregion custom Methods
}
