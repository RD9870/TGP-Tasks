<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Resources\Customer\CartResource;
use App\Models\Book;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Mime\Message;

class CartController extends Controller
{
    //return the current user cart with their payment method adress cart items and total
    public function index()
    {
        $cart = Cart::where('user_id', Auth::id())->first();
        return new CartResource($cart);
    }

    //store an item in the cart
    public function store(Request $request, string $book_id)
    {
        $user = Auth::user();
        //if user doesn't already hae a cart create it
        $cart = Cart::where('user_id', $user->id)->firstOrCreate([
            'user_id' => $user->id,
            'payment_method_id' => PaymentMethod::first()->id,
            'address' => $user->customer->address
        ]);
        //get a cart item with this id
        $cartItem = CartItem::where('cart_id', $cart->id)->where('book_id', $book_id)->first();
        //if a cart item already exsist increase the quantity
        if ($cartItem) {
            $cartItem->update([
                'qty' => $cartItem->qty + 1
            ]);
        } else {
            //check if the book exsists in the database
            $book = Book::where('id', $book_id)->first();
            if($book){
            // add item to the cart
            $cart->items()->create([
                'book_id' => $book_id,
                'qty' => 1
            ]);
            }
            else{
            //return a not found error
            return response()->json([
            'message' => 'the book you tried to add is not found'
            ],404);
            }

        }
        //decrement the author stock of this book
        $book = Book::findOrFail($book_id);
        if ($book->stock > 0){
        $book->decrement('stock');
        $book->save();
        //return a sucsess message
        return response()->json([
            'message' => 'item added'
        ]);
        }
        else{
            return response()->json([
            'message' => 'sorry this book is out of stock'
        ]);
        }
    }


    //remove a book ftrom cart
        public function destroy(String $book_id)
        // public function removeBook($book_id)
    {
        //get current user info
        $user = Auth::user();
        //get their cart
        $cart = Cart::where('user_id', $user->id)->firstOrfail();
        //get the cart item that needs to be removed
        $cartItem = CartItem::where('cart_id', $cart->id)->where('book_id', $book_id)->first();

        //if the cart item has multiple copies
        if($cartItem->qty > 1){
            $cartItem->decrement('qty');
        }
        else{
            //delete the cart item
            $cartItem->delete();
        }
        //dhoe user a message
        return response()->json([
            'message' => 'item removed from cart'
        ]);
    }


    //change the payment methid stored in the cart
        public function changePaymentMethod(Request $request){
        //get current user data
        $user = Auth::user();
        //validate the request input
        $request->validate([
            'payment_method_id'=> ['required','string','exists:payment_methods,id']
        ]);
        //get the user cart
        $cart = Cart::where('user_id', $user->id)->firstOrfail();
        //update payment method
        if($cart){
            $cart->update(["payment_method_id" => $request->payment_method_id]);
            //return an ok msg
            return response()->json([
                "Message"=> "owner of the cart with id $cart->id changed payment method",
                "new method"=> $request->payment_method_id
            ]);
        }
        //if cart not found return a fail msg
        else{
            return response()->json([
                "Message"=> "sorry the cart doesn't exsist",
            ]);
        }
    }
}
