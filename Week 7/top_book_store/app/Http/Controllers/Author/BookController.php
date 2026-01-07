<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB as FacadesDB;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        return User::findOrFail($user->id)->load('books');
    }

    //allows author to publish new books
    public function publishNewBook(Request $request)
    {
        //validate the input
        $inputs = $request->validate([
            'title' => ['required','max:255'],
            'publish_year' => ['required','min:4','max:4'],
            'price' => ['required','decimal:1,50'],
            'isbn' => ['required'],
            'category_id' => ['required','exists:categories,id'],
            'stock' => ['sometimes', 'integer','min:0'],
        ]);
        //create a new book
        $book = Book::create($inputs);
        //add the relation ship to book_user table
        FacadesDB::table('book_user')
            ->insert([
                'user_id'=> Auth::user()->id,
                'book_id'=> $book->id,
                'created_at'=>now(),
                'updated_at'=>now(),
            ]);
        //return the boook data
        return $book;
    }


    public function show(string $id)
    {
        //find($id) returns null
        $book = Book::findOrFail($id);
        //return the book matching the id
        return $book;
    }



    public function update(Request $request, string $id)
    {
         //find the book with the input is or return an error if no match
        $book = Book::findOrFail($id);
    //validate the user input
        $data = $request->validate([
            //use sone times bc the user ight want to update one or two fields unstead of all of them
            'title'=> ['sometimes', 'string'],
            'price'=> ['sometimes','numeric','decimal:0,3'],
            'publication_year'=> ['sometimes', 'string'],
            'ISBN'=> ['sometimes','string'],
            'category_id'=> ['sometimes','integer'],
        ]);
        //update the book witg the new data
        $book->update($data);
        //
        return response()->json(
        [
            //use => instead of : for the json data becuse it's php rn and will turn to json later
            'message'=> 'book added sucsessfully',
            'book'=> $book,
        ]
        );
    }


    /**
     * Update the specified resource in storage.
     */
    public function updateStock(Request $request, string $id)
    {
         //find the book with the input is or return an error if no match
        $book = Book::findOrFail($id);
    //validate the user input
        $data = $request->validate([
            'stock'=> ['required','integer','min:0'],
        ]);
        //update the book witg the new data
        $book->update($data);
        //
        return response()->json(
        [
            //use => instead of : for the json data becuse it's php rn and will turn to json later
            'message'=> 'stock updated sucsessfully',
            'book'=> $book,
        ]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function getAuthorOrders(Request $request)
    {
        //get current user info
        $user = Auth::user();
        //get the ids of this author's books
        $books = FacadesDB::table('book_user')
            ->select("book_id")
            ->where("user_id",$user->id)
            ->get();
        //initiate an order array
        $orders = [];
        //loop through the books
            foreach($books as $book){
            //get how many times someone ordered this book
            $orderCount = FacadesDB::table('order_items')
            ->select("*")
            ->where("book_id", $book->book_id)
            ->count();
            //get the book data
            $book = FacadesDB::table('books')
            ->select("*")
            ->where("id",$book->book_id)
            ->first();
            //add the related data to the array
            $orders[] = [
                "title" => $book->title,
                "number of orders" => $orderCount
            ];
            }
            //return the orders info
            return response()->json([
                "orders"=> $orders
            ]);
    }


    //delete a book from db
    public function destroy(string $id)
    {
    //find the book with the input is or return an error if no match
    $book = Book::findOrFail($id);
    //delete the book
        $book->delete();
    //return a sucsess message
        return response()->json(['message' =>  `Book with id: $id was deleted successfully`]);
    }
}
