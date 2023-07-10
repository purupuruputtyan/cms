@extends('layouts.app')
@section('content')

<div class="card-body">
    <div class="card-body">
        <table class="table table-striped task-table">
            <!-- テーブルヘッダ -->
            <thead>
                <th>ユーザー名</th>
                <th>画像</th>
                <th>本のタイトル</th>
                <th>公開日</th>
                <th>金額</th>
                <th>ページ数</th>
                <th>&nbsp;</th>
            </thead>
            <!-- テーブル本体 -->
            <tbody>
                <tr>
                    <!-- 本の記録概要 -->
                    <td class="table-text">
                      <div>{{ $book->user->name }}</div>
                    </td>
                    <td class="table-text">
                      <div><img src="{{ asset('../upload/' . $book->item_img) }}" width="100"></div>
                    </td>
                    <td class="table-text">
                        <div>{{ $book->item_name }}</div>
                    </td>
                    <td class="table-text">
                        <div>{{ $book->published }}</div>
                    </td>
                    <td class="table-text">
                        <div>{{ $book->item_amount }}</div>
                    </td>
                    <td class="table-text">
                        <div>{{ $book->item_number }}</div>
                    </td>
                    <!--本: 更新ボタン-->
                    <td>
                        <form action="{{ url('booksedit/'.$book->id) }}" method="GET">
                            @csrf
                            <button type="submit" class="btn btn-success">
                                更新
                            </button>
                        </form>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<div>
    <a href="{{ route('books.index') }}" class="btn btn-primary ml-5">一覧に戻る</a>
</div>

@endsection