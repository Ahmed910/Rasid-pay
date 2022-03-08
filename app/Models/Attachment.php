<?php

namespace App\Models;

use App\Http\Requests\V1\Dashboard\AttachmentRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;
use Illuminate\Support\Facades\Request;

class Attachment extends Model
{
    use HasFactory, Uuid;

    #region properties
    protected $guarded = ['created_at', 'updated_at'];
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
    #endregion relationships

    #region custom Methods
    public static function storeImage(AttachmentRequest $attachmentRequest, $user_id)
    {


        if ($attachmentRequest->has("files")) {
            foreach ($attachmentRequest->file('files') as $file) {
                $attachment = new Attachment();
                $path = $file->store('/files/client', ['disk' => 'local']);
                $attachment->user_id = $user_id;
                $attachment->file = $path;
                $attachment->file_type = $file->getClientMimeType();
                $attachment->title = $attachmentRequest->title;
                $attachment->save();
            }
        }


    }
    #endregion custom Methods
}
