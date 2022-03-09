<?php

namespace App\Models;

use App\Http\Requests\V1\Dashboard\AttachmentRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;

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
    public static function storeImage(AttachmentRequest $attachmentRequest, $user)
    {
        foreach ($attachmentRequest->file('files') as $file) {
            $user->attachments()->create([
                'file'      => $file->store('/files/client', ['disk' => 'local']),
                'file_type' => $file->getClientMimeType(),
                'title'     => $attachmentRequest->title
            ]);
        }
    }
    #endregion custom Methods
}
