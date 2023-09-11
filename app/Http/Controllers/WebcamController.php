<?php

namespace App\Http\Controllers;

use App\Models\ProjectAssign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;


class WebcamController extends Controller
{
    public function show($users, $pad)
    {
        $selectedValue = $pad;
        $update = ProjectAssign::where('users_id', '=', Auth::user()->id)
            ->where('projectactivitydetail_id', '=', $pad)
            ->update(['waktuSelesai' => date('H:i:s')]);
        $data = ProjectAssign::where('users_id', '=', Auth::user()->id)->where('projectactivitydetail_id', '=', $pad)->get()[0];
        return view('webcam', compact('data'));
    }

    public function store(Request $request,$pad)
    {
        $img = $request->image;
        $folderPath = "images/";

        $image_parts = explode(";base64,", $img);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];

        $image_base64 = base64_decode($image_parts[1]);
        $fileName = uniqid() . '.png';

        $file = $folderPath . $fileName;
        File::put($file, $image_base64);

        $lat = $request->input('lat');
        $long = $request->input('long');

        $update = ProjectAssign::where('users_id', '=', Auth::user()->id)
            ->where('projectactivitydetail_id', '=', $pad)
            ->update([
                'image' => DB::raw("CONCAT(image, ',' '$fileName')"),
                'latitude' => DB::raw("CONCAT(latitude, ',' '$lat')"),
                'longitude' => DB::raw("CONCAT(longitude, ',' '$long')")
            ]);
        
        return redirect('/user')->with('status', 'Foto dan Lokasi anda telah berhasil diupload');
    }
}
