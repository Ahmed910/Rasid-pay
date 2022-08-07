<?php

namespace App\Http\Controllers\Api\V1\Mobile;

use Validator;
use App\Models\Test;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class TestController extends Controller
{
    public function sendData(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'nullable',
                'image' => 'nullable|max:1024|mimes:jpg,png,jpeg',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }


        if ($request->file('image')) {

            $imageName = time() . '_' .$request->file('image')->getClientOriginalName();
             $request->file('image')->storeAs(
                'tests', $imageName
            );

            //store your file into database
            Test::create([
                'name' => $request->name,
                'image' => $imageName,
            ]);

            return response()->json([
                "success" => true,
                "message" => "Data successfully uploaded",
                "file" => url("/storage/tests")."/" . $imageName
            ]);
        }
    }
}
