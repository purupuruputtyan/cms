@extends('layouts.app')
@section('content')

    <!-- Bootstrapの定形コード… -->
    <div class="card-body">
        <!-- バリデーションエラーの表示に使用-->
        @include('common.errors')
        <!--フラッシュメッセージの表示-->
        @if (session('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif

    <!-- 検索フォーム -->
    <form action="{{ route('search') }}" method="GET" class="form-inline my-2 my-lg-0">
        <input class="form-control mr-sm-2 ml-5" type="search" placeholder="キーワードを入力" name="search" value="{{ $search }}">
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">検索</button>
    </form>

    <!-- 検索結果表示 -->
    @foreach ($books as $book)
        <!-- 検索結果の表示内容 -->
        @if (count($books) > 0)
            <h4 class="ml-5 mt-5">本一覧</h4>
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
                            <th>数</th>
                            <th>&nbsp;</th>
                            <th>&nbsp;</th>
                        </thead>
                        <!-- テーブル本体 -->
                        <tbody>
                            @foreach ($books as $book)
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
                                    <!-- 本: 削除ボタン -->
                                    <td>
                                      <form action="{{ url('book/'.$book->id) }}" method="POST">
                                        @csrf               <!-- CSRFからの保護 -->
                                        @method('DELETE')   <!-- 擬似フォームメソッド -->

                                        <button type="submit" class="btn btn-danger" onclick="return confirm('削除してもよろしいですか？')">
                                            削除
                                        </button>
                                     </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 offset-md-4">
                    {{ $books->links()}}
                </div>
            </div>
        @endif
    @endforeach

    <div>
        <a href="{{ route('books.index') }}" class="btn btn-primary">一覧に戻る</a>
    </div>

@endsection