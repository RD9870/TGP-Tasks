<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB as FacadesDB;
use Symfony\Component\Mime\Message;

class BookController extends Controller
{
    //show all books in the database
    public function index(Request $request)
    {
        $booksQuery = Book::query();
        if($request->has('cat'))
        {
            $booksQuery->where('category_id',$request->cat);
        }
        return $booksQuery->get();
    }


    //filter books by cat
    public function filterByCategory(string $id)
    {
        //query books table
        $books = FacadesDB::table('books')
        //get all books
            ->select("*")
        //that have the input id
            ->where("category_id",$id)
            ->get();
        //return a list of books
            return response()->json([
                "books"=>$books
            ]);
    }
}
