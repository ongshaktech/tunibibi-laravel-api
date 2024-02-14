<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ProductImageController extends Controller
{
    function Store(Request $request){

        $image_array=array();

        for($a=0; $a<count($request->image); $a++){

            list($type, $imageData) = explode(';', $request->image[$a]);
            list(,$extension) = explode('/',$type);
            list(,$imageData)      = explode(',', $imageData);
            $fileName = uniqid().'.'.$extension;
            $imageData = base64_decode($imageData);
            $imageData=str_replace("data:image/png;base64,","",$imageData);


            $compressedImage = Image::make($imageData)
                ->resize(800, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->encode("png", 20); // 75 is the quality percentage


            Storage::disk("public")->put("products/".$fileName,$compressedImage);


            $id= ProductImage::insertGetId([
                "product_id"=>$request->product_id,
                "img"=>$fileName
            ]);



            array_push($image_array,["id"=>$id,"img"=>config("app.url")."storage/products/".$fileName]);
        }

        return response()->json([
            "error"=>false,
            "msg"=>"Successfully Product Image Added",
            "images"=>$image_array
        ]);
    }

    function Delete($id){

        $images=ProductImage::where("id",$id)->get();

        foreach ($images as $value){
            File::delete(config("app.url")."storage/products/".$value->img);
        }
        ProductImage::where("id",$id)->delete();
        return response()->json([
            "error"=>false,
            "msg"=>"Successfully Product Image Deleted"
        ]);
    }

}
