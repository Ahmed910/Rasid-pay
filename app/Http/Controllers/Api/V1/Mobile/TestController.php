<?php

namespace App\Http\Controllers\Api\V1\Mobile;

use App\Models\Test;
use Illuminate\Http\Request;
use App\Http\Requests\V1\Mobile\TestRequest;
use App\Http\Controllers\Controller;


class TestController extends Controller
{
    public function sendData(TestRequest $request)
    {
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
