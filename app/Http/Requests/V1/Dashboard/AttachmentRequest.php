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
        $data = ["attachments" => "required"];
        $map = [
            "videos" => 'required|mimetypes:video/avi,video/mpeg,video/quicktime',
            "images" => 'required|mimes:jpeg,jpg,png,suv,heic',
            "docs" => 'required|mimes:doc,pdf,docx,zip,txt',
            "voices" => 'required|mimes:application/octet-stream,audio/mpeg,mp3,wav',
            "delegate" => 'required|mimes:doc,pdf,docx,zip,rar,jpeg,jpg,png,suv,heic',
            "identity" => 'required|mimes:doc,pdf,docx,zip,rar,jpeg,jpg,png,suv,heic',
            "other" => 'required|mimes:doc,pdf,docx,zip,rar,jpeg,jpg,png,suv,video/avi,video/mpeg,video/quicktime,application/octet-stream,audio/mpeg,mp3,wav',
        ];
        $data["attachments.*.title"] = "required|max:100|min:3";
        $data["attachments.*.type"] = "required|in:delegate,identity,docs,images,videos,voices,other";
        if (isset($this->attachments))
//    dd($this->attachments);
            for ($i = 0; $i < count($this->attachments); $i++) {
                $data["attachments." . $i . ".files"] = "required|array";
                if ($this->attachments[$i]["type"] == "delegate" || $this->attachments[$i]["type"] == "identity") $data["attachments." . $i . ".files"] .= "|size:1";
                if (isset($map[$this->attachments[$i]["type"]])) $data["attachments." . $i . ".files.*"] = $map[$this->attachments[$i]["type"]];


            }
//dd($data);
        return $data;

//// TODO max sizes needs to be handled

    }
}
