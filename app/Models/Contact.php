<?php

namespace App\Models;

use App\Models\MessageType\MessageType;
use App\Traits\Loggable;
use App\Traits\Uuid;
use GeniusTS\HijriDate\Hijri;
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
    const USER_COLUMNS = ["message_source", "message_status"];
    const SELECT_ALL = ["contact_type", "message_source", "message_status"];
    const CONTACTS = ['fullname', 'email',  'phone','created_at'];
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

    #endregion mutators

    #region scopes
    public function scopeSearch($query, $request)
    {
        $old = $query->toSql();

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

            if (in_array($key, ['contact_type'])) {
                $query->whereHas('messageType', function ($q) use ($item) {
                    $q->whereHas('translations', fn ($q) => $q->where('name', 'like', "%$item%"));
                });
            }

            if ($request->message_types && is_array($request->message_types)) {
                $query->whereIn('message_type_id', $request->message_types);
            }

            if (key_exists($key, self::ADMINCOLUMNS))
                $query->whereHas('assignedTo', function ($q) use ($key, $item) {
                    $key = self::ADMINCOLUMNS[$key];
                    !($key == "fullname") ? $q->where($key, $item) : $q->where($key, "like", "%$item%");
                });
        }
        $new = $query->toSql();
        if ($old != $new || $request->message_source == -1 || $request->message_status == -1) {
            Loggable::addGlobalActivity($this, array_merge($request->query(), $this->searchParams($request)), ActivityLog::SEARCH, 'index');
        }
    }

    public function scopeSortBy(Builder $query, $request)
    {
        if (
            !isset($request->sort["column"]) || !isset($request->sort["dir"])
            || !in_array(Str::lower($request->sort["dir"]), ["asc", "desc"])
        ) return $query->latest('contacts.created_at');


        if (in_array($request->sort["column"], self::USER_COLUMNS)) {
            return $query->orderBy($request->sort["column"], $request->sort["dir"])->latest();
        }
        if (key_exists($request->sort["column"], self::ADMINCOLUMNS)) {
            return $query->leftJoin('users', 'users.id', '=', 'contacts.assigned_to_id')
                ->select("contacts.*", "users.fullname as admin.")
                ->orderBy('users.' . self::ADMINCOLUMNS[$request->sort["column"]], @$request->sort["dir"])->latest();
        }

        if (in_array($request->sort["column"], ['contact_type'])) {
            $query->orderBy('message_type_id', $request->sort["dir"])->latest();
        }

        if (in_array($request->sort["column"], self::CONTACTS)) {
            return $query->orderBy($request->sort['column'], $request->sort['dir'])->latest();
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
    private function searchParams($request)
    {
        $searchParams = [];
        if ($request->has('message_status')) {
            $searchParams['message_status'] = __('dashboard.contact.message_status.' . $request->message_status);
        }

        if ($request->has('message_source')) {
            $searchParams['message_source'] = __('dashboard.contact.message_sources.' . $request->message_source);
        }
        if ($request->has('message_types')) {
            $searchParams['message_types'] = MessageType::find($request->message_types)?->pluck('name')?->join(', ');
        }

        return $searchParams;
    }
    #endregion custom Methods
}
