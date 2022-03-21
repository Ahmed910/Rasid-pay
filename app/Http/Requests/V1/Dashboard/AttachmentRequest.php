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
        $data = [];
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

        for ($i = 0; $i < count($this->attachments); $i++) {
            $data["attachments." . $i . ".files"] = "required|array";
            if ($this->attachments[$i]["type"] == "delegate"||$this->attachments[$i]["type"] == "identity") $data["attachments." . $i . ".files"] .= "|size:1";
            if (isset($map[$this->attachments[$i]["type"]])) $data["attachments." . $i . ".files.*"] = $map[$this->attachments[$i]["type"]];


        }

        return $data;


//
//        foreach ($this->attachments){
//            $data = [];
//
//// TODO max sizes needs to be handled
//        if ($this->attachment_type == 'videos') {
//            $data = [
//                'files.*' => 'required|mimetypes:video/avi,video/mpeg,video/quicktime',
//            ];
//        } else if ($this->attachment_type == 'images') {
//            $data = [
//                "files" => ["required", "array"],
//                'files.*' => ['mimes:jpeg,jpg,png,suv,heic'],
//
//
//            ];
//        } else if ($this->attachment_type == 'docs') {
//            $data = [
//                "files" => ["required", "array"],
//                'files.*' => 'required|mimes:doc,pdf,docx,zip,txt',
//            ];
//        } else if ($this->attachment_type == 'voices') {
//            $data = [
//                "files" => ["required", "array"],
//                'files.*' => 'required|mimes:application/octet-stream,audio/mpeg,mp3,wav',
//            ];
//        } else if ($this->attachment_type == 'delegate' || $this->attachment_type == 'identity') {
//            $data = [
//                'file' => 'required|mimes:doc,pdf,docx,zip,rar,jpeg,jpg,png,suv',
//            ];
//        } else {
//            $data = [
//                "files" => ["required", "array"],
//                'files.*' => 'required|mimes:doc,pdf,docx,zip,rar,jpeg,jpg,png,suv,video/avi,video/mpeg,video/quicktime,application/octet-stream,audio/mpeg,mp3,wav',
//            ];
//        }
//
//
//        $rules = [
////          "user_id"=>["required", "exists:users,id"],
//            "attachment_type" => ["required", "in:delegate,identity,docs,images,videos,voices,other"],
//            "title" => ["required", "max:100", "min:3"],
//        ];
//
//        $rules += $data;
//        return $rules;
//        }
    }
}
