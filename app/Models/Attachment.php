<?php

namespace App\Models;

use App\Http\Requests\V1\Dashboard\AttachmentRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;
use Illuminate\Support\Facades\Storage;

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
        $index = -1;
        foreach ($attachmentRequest->attachments as $item) {
            $index++;
            if (isset($item["files"])) foreach ($item["files"] as $file) {
                $user->attachments()->create([
                    'file' => $file->store('/files/client', ['disk' => 'local']),
                    'file_type' => $file->getClientMimeType(),
                    'title' => $item["title"],
                    'attachment_type' => $item["type"],
                    "group_id" => $index
                ]);
            }
        }
    }

    public static function deletefiles(AttachmentRequest $attachmentRequest, $client)
    {
        foreach ($attachmentRequest->attachments as $item) {
            $attachments = Attachment::where("user_id", $client->user_id)->where("attachment_type", $item["type"])->get();
            $paths = $attachments->pluck("attachments");
            foreach ($paths as $path) {
                if (Storage::exists($path)) {
                    Storage::delete($path);
                }
            }
            $attachments->each->delete();
        }
    }
    #endregion custom Methods
}
