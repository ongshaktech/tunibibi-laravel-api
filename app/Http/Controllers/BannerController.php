<?php

namespace App\Http\Controllers;

use App\Models\buyer_banners;
use Illuminate\Http\Request;
use App\Models\Banner;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{

    function GetBanners()
    {


        $data = Banner::get();

        if ($data != null) {

            $banners = array();

            for ($a = 0; $a < count($data); $a++) {
                array_push($banners, config("app.url") . "storage/seller/banner/" . $data[$a]["image"]);
            }

            return response()->json([
                "error" => false,
                "data" => $banners
            ]);
        } else {
            return response()->json([
                "error" => true,
                "msg" => "Opps! Something is wrong!"
            ]);
        }


    }


    function getbuyerbanner()
    {

        $data = buyer_banners::get();

        if ($data != null) {

            $banners = array();

            foreach ($data as $value) {
                array_push($banners, [
                    "id" => $value->id,
                    "country" => $value->country,
                    "img" => config("app.url") . "storage/buyer/banner/" . $value->image,
                ]);
            }

            return response()->json([
                "error" => false,
                "data" => $banners
            ]);
        } else {
            return response()->json([
                "error" => true,
                "msg" => "Opps! Something is wrong!"
            ]);
        }

    }



    function store(Request $request)
    {
        list($type, $imageData) = explode(';', $request->image);
        list(, $extension) = explode('/', $type);
        list(, $imageData) = explode(',', $imageData);
        $fileName = uniqid() . '.' . $extension;
        $imageData = base64_decode($imageData);

        Storage::disk("public")->put("buyer/banner/" . $fileName, $imageData);

        buyer_banners::create(["image" => $fileName, "country" => $request->country]);
        return Response()->json(["error" => false, "msg" => "Successfully Banner Added"]);
    }

    function update($id, Request $request)
    {
        list($type, $imageData) = explode(';', $request->image);
        list(, $extension) = explode('/', $type);
        list(, $imageData) = explode(',', $imageData);
        $fileName = uniqid() . '.' . $extension;
        $imageData = base64_decode($imageData);

        Storage::disk("public")->put("buyer/banner/" . $fileName, $imageData);

        buyer_banners::where("id", $id)->update(["image" => $fileName, "country" => $request->country]);
        return Response()->json(["error" => false, "msg" => "Successfully Banner Update"]);
    }


    function delete($id)
    {
        buyer_banners::where("id", $id)->delete();
        return Response()->json(["error" => false, "msg" => "Successfully Banner Deleted"]);
    }






}
