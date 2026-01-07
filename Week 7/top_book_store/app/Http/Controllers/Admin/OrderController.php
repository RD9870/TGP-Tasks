<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB as FacadesDB;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{
        public function changeOrderStatus(Request $request)
    {
        //validate the request parameters
        $data = request()->validate([
            "orderId"=> ["required","integer",],
            "newStatus" => ["required","string", Rule::in(['completed', 'pending', 'canceled'])]
        ]);
        //change the status of the order with the imput id
        FacadesDB::table('orders')
            ->where("id", $data["orderId"])
            ->update( ["status" => $data["newStatus"]]);
        //return a message to the user
            return response()->json([
                "message"=> "order with the id ". $data["orderId"] ." has been xhanged to " . $data["newStatus"] ,
            ]);
    }


}
