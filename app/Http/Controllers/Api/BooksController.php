<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Book;
use App\Author;
use App\PublishingHouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;

class BooksController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getBooks()
    {
        $books = Book::with(['authors','publishingHouses'])->get();

        if (!isset($books[0])) {
             $books = 'Books don`t exist';
        }
        return response()->json($books);
    }
    public function createBook($book, $author, $publishingHouse)
    {
        $data = ['book' => $book, 'author' => $author, 'publishingHouse' => $publishingHouse];
        $validator = Validator::make($data, [
            'book' => 'required|string|min: 3|max: 30',
            'author' => 'required|string|min: 3|max: 30',
            'publishingHouse' => 'required|string|min: 3|max: 30',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        } else {
            $check_book = Book::where('name', $book)->get()->first();
            if (isset($check_book->name)) {
                return response()->json(['error' => 'The book already exists']);
            } else {
                $book = Book::create([
                    'name' => $book,
                ]);
                $check_author = Author::where('name', $author)->get()->first();
                if (isset($check_author->name)) {
                    $book->authors()->attach($check_author);
                } else {
                    $check_author = Author::create([
                        'name' => $author,
                    ]);
                    $book->authors()->attach($check_author);
                }
                $check_publishingHouse = publishingHouse::where('name', $publishingHouse)->get()->first();
                if (isset($check_publishingHouse->name)) {
                    $book->publishingHouses()->attach($check_publishingHouse);
                } else {
                    $check_publishingHouse = publishingHouse::create([
                        'name' => $publishingHouse,
                    ]);
                    $book->publishingHouses()->attach($check_publishingHouse);
                }
            }
        }
        return response()->json(['success' => 'Book created']);
    }

    public function editBook($book, $author, $publishingHouse)
    {
        $data = ['book' => $book, 'author' => $author, 'publishingHouse' => $publishingHouse];
        $validator = Validator::make($data, [
            'book' => 'required|string|min: 3|max: 30',
            'author' => 'required|string|min: 3|max: 30',
            'publishingHouse' => 'required|string|min: 3|max: 30',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        } else {
            $check_book = Book::where('name', $book)->get()->first();
            if (isset($check_book->name)) {
                $book = Book::where('name', $book)->get()->first();
                $check_author = $book->authors()->where('name', $author)->get()->first();
                if (isset($check_author->name)) {
                } else {
                    $check_author = Author::create([
                        'name' => $author,
                    ]);
                    $book->authors()->attach($check_author);
                }
                $check_publishingHouse = $book->publishingHouses()->where('name', $publishingHouse)->get()->first();
                if (isset($check_publishingHouse->name)) {
                } else {
                    $check_publishingHouse = publishingHouse::create([
                        'name' => $publishingHouse,
                    ]);
                    $book->publishingHouses()->attach($check_publishingHouse);
                }
            } else {
                return response()->json(['error' => 'The book doesn`t exists']);
            }
        }
        return response()->json(['success' => 'The book is updated']);
    }

    public function deleteBook($book)
    {
        $book = Book::where('name', $book)->get()->first();
        if (isset($book->name)) {
            $book->authors()->detach();
            $book->publishingHouses()->detach();
            $book->delete();
        } else {
            return response()->json(['error' => 'Book does not exist']);
        }
        return response()->json(['success' => 'Book successfully deleted']);
    }
}
