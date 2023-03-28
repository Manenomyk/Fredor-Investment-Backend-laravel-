<?php

namespace App\Http\Controllers\API;

use App\Models\customerlist;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class customerlistcontoller extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [            'plate_name' => 'required',
            'plate_code' => 'required',
            'driver' => 'required',
            'id_no' => 'required',
            'phone' => 'required',
            'company' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'validation_errors' => $validator->messages()->all()
            ], 422);
        }else {
            $customerlist = new customerlist;
            $customerlist->plate_name = $request->input('plate_name');
            $customerlist->plate_code = $request->input('plate_code');
            $customerlist->driver = $request->input('driver');
            $customerlist->id_no = $request->input('id_no');
            $customerlist->phone = $request->input('phone');
            $customerlist->company = $request->input('company');
            $customerlist->save();
            return response()->json([
                'status' => 200,
                'massage' => "customerlist added successfully",
            ]); 
        }
    }
    public function index()
    {
        $customerlist = customerlist::all();
        return response()->json([
            'status' => 200,
            'viewcustomerlist'=>$customerlist,
        ]);

    }

}
