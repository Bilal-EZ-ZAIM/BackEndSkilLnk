<?php

namespace App\Http\Controllers;

use App\Models\UplodImage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;


use Illuminate\Support\Facades\Validator;

class UplodImageController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */


    public function index()
    {
        $image =   UplodImage::where('id', 4)->first();


        // return view('imag', compact('image'));
        return response()->json($image);
    }

    public function upload(Request $request)
    {
        $imagesName = [];
        $response = [];

        $validator = Validator::make(
            $request->all(),
            [
                'images' => 'required',
                'images.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
            ]
        );

        if ($validator->fails()) {
            return response()->json(["status" => "failed", "message" => "Validation error", "errors" => $validator->errors()]);
        }

        if ($request->has('images')) {
            foreach ($request->file('images') as $image) {
                $filename = Str::random(32) . "." . $image->getClientOriginalExtension();
                $image->move('uploads/', $filename);

                UplodImage::create([
                    'image_name' => $filename
                ]);
            }

            $response["status"] = "successs";
            $response["message"] = "Success! image(s) uploaded";
        } else {
            $response["status"] = "failed";
            $response["message"] = "Failed! image(s) not uploaded";
        }
        return response()->json($response);
    }
    public function store(Request $request)
    {
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            if ($image->isValid()) {
                $filename = Str::random(32) . '.' . $image->getClientOriginalExtension();

                $image->storeAs('public/uploads', $filename);

                UplodImage::create([
                    'image' =>  $filename,
                ]);

                return response()->json([
                    'image' => $filename,
                ]);
            } else {
                return response()->json([], 400);
            }
        } else {
            return response()->json([], 400);
        }
    }

    

    public function getImage()
    {
        $image =  UplodImage::all();
        return response()->json($image);
    }
}
