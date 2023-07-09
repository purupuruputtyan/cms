<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Book;
use Auth;
use Illuminate\Support\Facades\Storage;

class BooksController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $search = $request->input('search');
        $books = Book::searchBooksByUserId(Auth::user()->id, $search);

        if ($search) {
            return view('books.search', [
                'books' => $books,
                'search' => $search
            ]);
        }

        return view('books.index', [
            'books' => $books,
            'search' => $search
        ]);
    }

    // BooksController.php

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
    
            // 画像のアップロード処理
            if ($request->hasFile('item_img')) {
                $file = $request->file('item_img');
                $filename = $file->getClientOriginalName();
                $file->move('upload', $filename);
                $book->item_img = $filename;
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

}