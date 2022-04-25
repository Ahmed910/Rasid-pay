<?php

namespace App\Http\Requests\V1\Dashboard;

use App\Http\Requests\ApiMasterRequest;

class AttachmentRequest extends ApiMasterRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $data = ["attachments" => "required_if:client_type,company,institution"];
        $data += [
            "attachments.*.title" => "required_with:attachments",
            "attachments.*.type" => "required_with:attachments",
            "attachments.*.id" => "exists:attachments,id",

        ];
        $map = [
            "videos" => 'mimetypes:video/avi,video/mpeg,video/mp4,video/quicktime',
            "images" => 'mimes:jpeg,jpg,png,suv,heic',
            "docs" => 'mimes:doc,pdf,docx,zip,txt',
            "voices" => 'mimes:application/octet-stream,audio/mpeg,mp3,wav',
            "delegate" => 'mimes:doc,pdf,docx,zip,rar,jpeg,jpg,png,suv,heic',
            "identity" => 'mimes:doc,pdf,docx,zip,rar,jpeg,jpg,png,suv,heic',
            "other" => 'mimes:doc,pdf,docx,zip,rar,jpeg,jpg,png,suv,video/avi,video/mpeg,video/quicktime,application/octet-stream,audio/mpeg,mp3,wav',
        ];
//        $data["attachments.*.id"] = "exists:attachments,id";
        $data["attachments.*.title"] .= "|max:100|min:3";
        $data["attachments.*.type"] .= "|in:delegate,identity,docs,images,videos,voices,other";

        if (isset($this->attachments))
            for ($i = 0; $i < count($this->attachments); $i++) {
                $data["attachments." . $i . ".files"] = "array";
                if (isset ($this->attachments[$i]["id"]) == false) {
                    $data["attachments." . $i . ".files"] = "required|" . $data["attachments." . $i . ".files"];
                }

                if (isset ($this->attachments[$i]["deleted_files"])) {
                    $data["attachments." . $i . ".id"] = "required|exists:attachments,id";
                    $data["attachments." . $i . ".deleted_files.*"] = "exists:attachment_files,id,attachment_id," . @$this->attachments[$i]["id"];
                }

                if (isset($this->attachments[$i]["type"])) {
                    if ($this->attachments[$i]["type"] == "delegate" || $this->attachments[$i]["type"] == "identity") {
                        $data["attachments." . $i . ".files"] .= "|size:1";
                        $data ["attachments." . $i . ".type"] = "distinct|in:delegate,identity,docs,images,videos,voices,other";
                    }

                    if (isset($map[$this->attachments[$i]["type"]])) $data["attachments." . $i . ".files.*"] = $map[$this->attachments[$i]["type"]];
                }
            }
        return $data;

//// TODO max sizes needs to be handled

    }
}
