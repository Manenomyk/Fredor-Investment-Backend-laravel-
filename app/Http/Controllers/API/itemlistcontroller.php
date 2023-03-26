<?php

namespace App\Http\Controllers\API;

use App\Models\itemlist;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\FuncCall;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Symfony\Contracts\Service\Attribute\Required;

class itemlistcontroller extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'description' => 'Required',
            'b_price' => 'Required',
            's_price' => 'Required',

        ]);

        if ($validator->fails()) {
            return response()->json([
                'validation_errors' => $validator->messages()->all()
            ], 422);
        } else {
            $itemlist = new itemlist;
            $itemlist->description = $request->input('description');
            $itemlist->b_price = $request->input('b_price');
            $itemlist->s_price = $request->input('s_price');
            $itemlist->save();
            return response()->json([
                'status' => 200,
                'massage' => "Item added successfully",
            ]);
        }
    }
}
