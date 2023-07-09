<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Book;
use League\Csv\Writer;
use League\Csv\Reader;

class CSVController extends Controller
{
    public function download()
    {
        $books = Book::all();

        $csv = Writer::createFromFileObject(new \SplTempFileObject());
        $csv->insertOne(['user_id',
                         'id',
                         'item_name',
                         'item_number',
                         'item_amount',
                         'published',
                         'item_img'
                         ]); // CSVヘッダー行を追加

        foreach ($books as $book) {
            $csv->insertOne([$book->user_id,
                             $book->id,
                             $book->item_name,
                             $book->item_number,
                             $book->item_amount,
                             $book->published,
                             $book->item_img
                             ]);
        }

        $csv->output('books.csv');
    }

    public function import(Request $request)
    {
        $file = $request->file('csv_file');

        $csv = Reader::createFromPath($file->getPathname(), 'r');
        $csv->setHeaderOffset(0);

        foreach ($csv as $row) {
            Book::create([
                'user_id' => $row['user_id'],
                'id' => $row['id'],
                'item_name' => $row['item_name'],
                'item_amount' => $row['item_amount'],
                'item_amount' => $row['item_amount'],
                'published' => $row['published'],
                'item_img' => $row['item_img']
            ]);
        }

        return redirect()->back()->with('success', 'CSV import successful.');
    }
}
