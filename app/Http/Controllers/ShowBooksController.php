<?php

namespace App\Http\Controllers;

use App\Book;

class ShowBooksController extends Controller
{
    public function show()
    {
        $books = Book::all();
       
        if (isset($books[0])) {
            $books = Book::paginate(6);
        }else{
            $books = collect();
        }
        return view('welcome',compact('books'));
    }
}