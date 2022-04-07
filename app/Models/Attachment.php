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
        foreach ($attachmentRequest->attachments as $item) {
            $paths = [];
            if (isset($item["files"])) {
                foreach ($item["files"] as $file) {
                    $paths[] = $file->store('/files/client', ['disk' => 'local']);
                }
                $user->attachments()->create([
                    'file' => json_encode($paths),
                    'file_type' => $file->getClientMimeType(),
                    'title' => $item["title"],
                    'attachment_type' => $item["type"],
                ]);
            }
        }
    }

    public static function deletefiles(AttachmentRequest $attachmentRequest, $client)
    {
        foreach ($attachmentRequest->attachments as $baseitem) {
            $attachments = Attachment::where("user_id", $client->user_id)->where("attachment_type", $baseitem["type"])->where("title", $baseitem["title"])->get();
            $res = $attachments->pluck("file");
            foreach ($res as $item) {
                $item = json_decode($item);
                foreach ($item as $path) {
                    if (Storage::exists($path)) {
                        Storage::delete($path);
                    }
                }
                Attachment::where("user_id", $client->user_id)->where("attachment_type", $baseitem["type"])->delete();
            }


        }
    }
    #endregion custom Methods
}
