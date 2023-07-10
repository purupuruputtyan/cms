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
        } else {
            $filename = 'no_image.jpg'; // デフォルトの画像ファイル名
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
    
    public function show($book_id)
    {
        $book = Book::getBookByUserId($book_id, Auth::user()->id);
    
        if ($book) {
            return view('books.show', [
                'book' => $book
            ]);
        } else {
            return redirect('/')->with('error', '本が見つかりません');
        }
    }

}
