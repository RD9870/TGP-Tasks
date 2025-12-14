<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;


class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    //show all books in the database
    return Book::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //validate the user input from the request
        $data = $request->validate([
            "title"=> 'string',
            'price'=> 'numeric|decimal:0,3',
            'publication_year'=> 'string',
            'ISBN'=> 'string',
            'category_id'=> 'integer',
        ]);
        //create a new book with the new data
        $book = Book::create($data);
        //return a response with a message and the data from the new book
        return response()->json(
        [
            //use => instead of : for the json data becuse it's php rn and will turn to json later
            'message'=> 'book added sucsessfully',
            'book'=> $book,
        ]
        //code 201 to tell the requester that the creation process was sucsessfull
        , 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //find the book with the input is or return an error if no match
        //find($id) returns null
        $book = Book::findOrFail($id);
        //return the book matching the id
        return $book;
    }

    /**
     * Update the specified resource in storage.
     */
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
     * Remove the specified resource from storage.
     */
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
