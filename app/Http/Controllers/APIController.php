<?php

namespace App\Http\Controllers;

use App\UserDetail;
use Illuminate\Http\Request;

class APIController extends Controller
{
    public function store(Request $request){

        $name = $request->name;
        $email = $request->email;
        $phone_no = $request->phone_no;
        $disaster_timeline = $request->disaster_timeline;
        $lat = $request->lat;
        $long = $request->long;
        $desc = $request->desc;
        $status = $request->status;

        if ($request->has('photo_1') && $request->photo_1 != "") {
            $path = $request->file('photo_1')->store('uploads/design', 'public');
            $photo_1 = $path;
        } else {
            $photo_1 = "";
        }

        if ($request->has('photo_2') && $request->photo_2 != "") {
            $path = $request->file('photo_2')->store('uploads/design', 'public');
            $photo_2 = $path;
        } else {
            $photo_2 = "";
        }
        if ($request->has('photo_3') && $request->photo_3 != "") {
            $path = $request->file('photo_3')->store('uploads/design', 'public');
            $photo_3 = $path;
        } else {
            $photo_3 = "";
        }
        if ($request->has('photo_4') && $request->photo_4 != "") {
            $path = $request->file('photo_4')->store('uploads/design', 'public');
            $photo_4 = $path;
        } else {
            $photo_4 = "";
        }
        if ($request->has('photo_5') && $request->photo_5 != "") {
            $path = $request->file('photo_5')->store('uploads/design', 'public');
            $photo_5 = $path;
        } else {
            $photo_5 = "";
        }
        if ($request->has('photo_6') && $request->photo_6 != "") {
            $path = $request->file('photo_6')->store('uploads/design', 'public');
            $photo_6 = $path;
        } else {
            $photo_6 = "";
        }

        $details = new UserDetail();

        $details->name = $name;
        $details->email = $email;
        $details->phone_no = $phone_no;
        $details->disaster_timeline = $disaster_timeline;
        $details->lat = $lat;
        $details->long = $long;
        $details->desc = $desc;
        $details->status = $status;
        $details->photo_1 = $photo_1;
        $details->photo_2 = $photo_2;
        $details->photo_3 = $photo_3;
        $details->photo_4 = $photo_4;
        $details->photo_5 = $photo_5;
        $details->photo_6 = $photo_6;
        $details->save();

    $response = array(
    'status' => 'success',
    'msg' => 'New Details Request Send successfully',
    );
    return \Response::json($response);


    }
}
