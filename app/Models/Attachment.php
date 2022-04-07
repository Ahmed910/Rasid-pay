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

    protected $with = ['attachmentfiles'];

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
    public function attachmentfiles()
    {
        return $this->hasMany(AttachmentFile::class);
    }

    #region custom Methods
    public static function storeImage(AttachmentRequest $attachmentRequest, $user)
    {
        foreach ($attachmentRequest->attachments as $item) {
            $paths = [];
            if (isset($item["files"])) {
                $cur = $user->attachments()->create([
//                    'file' => json_encode($paths),
//                    'file_type' => $file->getClientMimeType(),
                    'title' => $item["title"],
                    'attachment_type' => $item["type"],
                ]);
                foreach ($item["files"] as $file) {
                    $curpath = $file->store('/files/client', ['disk' => 'local']);


////                dd($paths);
//                foreach ($paths as $curpath) {
                    $fileAttachment = new AttachmentFile();
                    $fileAttachment->create([
                        'path' => $curpath,
                        'type' => $file->getClientMimeType(),
                        "attachment_id" => $cur->id
                    ]);
                }
//dd($cur) ;
            }
        }
    }

    public static function deletefiles(AttachmentRequest $attachmentRequest, $client)
    {
//        $attachment = Attachment::find();
        foreach ($attachmentRequest->attachments as $baseitem) {
//            $attachment = Attachment::where("user_id", $client->user_id)->where("attachment_type", $baseitem["type"])->where("title", $baseitem["title"]);
////            $res = $attachment["attachmentfiles"] ;
////            dd($attachment->first()->attachmentfiles) ;
//            foreach ($attachment as $item) {
//                dd($item) ;
//                foreach ($item->attachmentfiles as $cur) {
//                    dd($cur);
//
//                }
//                $item = json_decode($item);
//                foreach ($item as $path) {
//                    if (Storage::exists($path)) {
//                        Storage::delete($path);
//                    }
//                }
            Attachment::where("user_id", $client->user_id)->where("attachment_type", $baseitem["type"])->delete();


        }
    }
    #endregion custom Methods
}
