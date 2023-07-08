<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Book;
use Auth;

class BooksController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $books = Book::getBooksByUserId(Auth::user()->id);

        return view('books.index', [
            'books' => $books
        ]);
    }

    public function edit($book_id)
    {
        $book = Book::getBookByUserId($book_id, Auth::user()->id);

        return view('books.edit', [
            'book' => $book
        ]);
    }

    public function update(Request $request)
    {
        $book = Book::getBookByUserId($request->id, Auth::user()->id);

        if ($book) {
            $validator = $book->validate($request->all());

            if ($validator->fails()) {
                return redirect('/')
                    ->withInput()
                    ->withErrors($validator);
            }

            $book->fill($request->only([
                'item_name',
                'item_number',
                'item_amount',
                'published',
            ]));
            $book->save();
        }

        return redirect('/');
    }

    public function store(Request $request)
    {
        $validator = Book::validate($request->all());

        if ($validator->fails()) {
            return redirect('/')
                ->withInput()
                ->withErrors($validator);
        }

        $file = $request->file('item_img');
        $filename = '';

        if (!empty($file)) {
            $filename = $file->getClientOriginalName();
            $file->move('../upload/', $filename);
        }

        $book = new Book;
        $book->user_id = Auth::user()->id;
        $book->item_name = $request->item_name;
        $book->item_number = $request->item_number;
        $book->item_amount = $request->item_amount;
        $book->item_img = $filename;
        $book->published = $request->published;
        $book->save();

        return redirect('/')->with('message', '本登録が完了しました');
    }

    public function destroy(Book $book)
    {
        $book->delete();
        return redirect('/');
    }
}
