<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//使うclassを宣言
use App\Book; //Bookモデルを使えるようにする
use Validator; //バリデーションを使えるようにする
use Auth; //認知モデルを使用する

class BooksController extends Controller
{
    //本ダッシュボード表示
    public function index() {
        $books = Book::orderBy('create_at' 'asc')->get();
        return view('books', [
            'books' => $books
        ]);
    }
    
    //更新画面
    public function edit(Book $books) {
        return view('booksedit', [
          'book' => $books
        ]);
    }
    
    //更新
    public function update(Request $request) {
        //バリデーション
        $validator = Validator::make($request->all(), [
            'id' => 'required'
            'item_name' => 'required|min:3|max:255',
            'item_number' => 'required|min:1|max:3',
            'item_amount' => 'required|max:6',
            'published' => 'required',
        ]);
        
        //バリデーション:エラー
        if ($varidator->fails()) {
            return rediret('/')
                ->withInput()
                ->wihErrors($validator);
        }
    }
    
    //登録
    public function store(Request $request) {
        //バリデーション
        $validator = Validator::make($request->all(), [
                'item_name' => 'required|min:3|max:255',
                'item_number' => 'required|min:1|max:3',
                'item_amount' => 'required|max:6',
                'published' => 'required',
        ]);
        //バリデーション:エラー 
        if ($validator->fails()) {
                return redirect('/')
                    ->withInput()
                    ->withErrors($validator);
        }
        //Eloquentモデル（登録処理）
        $books = new Book;
        $books->item_name = $request->item_name;
        $books->item_number = $request->item_number;
        $books->item_amount = $request->item_amount;
        $books->published = $request->published;
        $books->save();
        return redirect('/');
    }
        
    //削除処理
    public function destroy(Book $book) {
        $book->delete();
        return redirect('/');
    }

}
