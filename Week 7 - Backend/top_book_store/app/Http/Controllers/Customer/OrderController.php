<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB as FacadesDB;


class OrderController extends Controller
{
    //check customer out
    public function checkOut(Request $request){
        // get current user id
        $userId = $request->user()->id;
        //get the cart associated with the user
        $cart = FacadesDB::table('carts')
            ->select("*")
            ->where("user_id",$userId)
            ->first();
        //get the cart items associated with the cart
        $cartItems = FacadesDB::table('cart_items')
            ->select("*")
            ->where("cart_id",$cart->id)
            ->get();
        //if the cart has items
        if($cartItems->count() > 0){
            //initiate the cart total
        $total = 0;
        //loop throug  the cart items
        foreach ($cartItems as $item){
            //get book id from item
            $book_id = $item->book_id;
            //get book quantity from item
            $book_qty = $item->qty;
            //get book price from the database
            $book = FacadesDB::table('books')
            ->select("*")
            ->where("id",$book_id)
            ->first();
            $book_price=$book->price;
            //calculate book total
            $book_total = $book_price * $book_qty;
            //add book total to the final total
            $total += $book_total;
        }
        //crete a new order
        $order = Order::create([
            "user_id" => $userId,
            "total"    => $total,
            "payment_method_id" => $cart->payment_method_id,
            "address"=> $cart->address,
            "status"    => "pending",
        ]);
        //loop through the cart items an add them to the order
        foreach ($cartItems as $item){
        OrderItem::create([
                    "order_id" => $order->id,
                    "book_id" => $item->book_id,
                    "qty" => $item->qty,
                    "price" => $book->price,
        ]);
        //delete the item from cart items table
            FacadesDB::table('cart_items')->where('id', $item->id)->delete();
        }
        //return a msg
        return response()->json([
            "Message"=> "order was placed",
            "details"=> $order
        ]);
        }
        else{
            //return a msg
        return response()->json([
            "Message"=> "soryy your cart is empty"
        ]);
        }
    }

    //show customer list of past orders
    public function showOrders(){
        //get ucurrent user
        $user = Auth::user();
        //get orders from the data base
        $orderList = FacadesDB::table('orders')
            ->select("*")
            ->where("user_id",$user->id)
            ->get();
            //return the orders as jsom
            return response()->json([
                "orders" => $orderList
            ]);
    }
}


