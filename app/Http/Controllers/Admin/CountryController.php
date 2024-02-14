<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class CountryController extends Controller
{
    function Index()
    {
        $data = DB::table("country")->get();
        $new_data = array();
        foreach ($data as $value) {
            array_push($new_data, [
                "name" => $value->name,
                "code" => $value->code,
                "flag" => config("app.url") . "storage/country/" . $value->flag,
                "dollar_rate" => $value->dollar_rate,
                "currency_type" => $value->currency_type,
            ]);
        }

        return response()->json([
            "error" => false,
            "data" => $new_data
        ]);
    }


    function store(Request $request)
    {

        list($type, $imageData) = explode(';', $request->flag);
        list(, $extension) = explode('/', $type);
        list(, $imageData) = explode(',', $imageData);
        $fileName = uniqid() . '.' . $extension;
        $imageData = base64_decode($imageData);

        Storage::disk("public")->put("country/" . $fileName, $imageData);
        Country::create([
            "name" => $request->name,
            "code" => $request->code,
            "flag" => $fileName,
            "dollar_rate" => 0,
            "currency_type" => $request->currency_type,
        ]);

        return Response::json([
            "error" => false,
            "msg" => "Success Created"
        ]);

    }
    function update($id, Request $request)
    {

        list($type, $imageData) = explode(';', $request->flag);
        list(, $extension) = explode('/', $type);
        list(, $imageData) = explode(',', $imageData);
        $fileName = uniqid() . '.' . $extension;
        $imageData = base64_decode($imageData);

        Storage::disk("public")->put("country/" . $fileName, $imageData);
        Country::where("id", $id)->update([
            "name" => $request->name,
            "code" => $request->code,
            "flag" => $fileName,
            "dollar_rate" => 0,
            "currency_type" => $request->currency_type,
        ]);

        return Response::json([
            "error" => false,
            "msg" => "Successfully Updated"
        ]);

    }
    function dollarrate($id, Request $request)
    {

        Country::where("id", $id)->update([
            "dollar_rate" => $request->amount,
        ]);

        return Response::json([
            "error" => false,
            "msg" => "Successfully Updated"
        ]);

    }

    function delete($id, Request $request)
    {
        Country::where("id", $id)->delete();
        return Response::json([
            "error" => false,
            "msg" => "Successfully Deleted"
        ]);
    }

}
