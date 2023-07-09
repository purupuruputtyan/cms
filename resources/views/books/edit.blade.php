@extends('layouts.app')
@section('content')
<div class="row container">
    <div class="col-md-12">
        @include('common.errors')
        <form action="{{ url('books/update') }}" method="POST" enctype="multipart/form-data">
            <!-- item_name -->
            <div class="form-group">
                <label for="item_name">本の題名</label>
                <input type="text" name="item_name" class="form-control" value="{{ $book->item_name }}">
            </div>
            <!-- /item_name -->

            <!-- item_amount -->
            <div class="form-group">
                <label for="item_amount">金額</label>
                <input type="text" name="item_amount" class="form-control" value="{{ $book->item_amount }}">
            </div>
            <!-- /item_amount -->

            <!-- item_number -->
            <div class="form-group">
                <label for="item_number">ページ数</label>
                <input type="text" name="item_number" class="form-control" value="{{ $book->item_number }}">
            </div>
            <!-- /item_number -->

            <!-- published -->
            <div class="form-group">
                <label for="published">公開日</label>
                <input type="datetime" name="published" class="form-control" value="{{ $book->published }}" />
            </div>
            <!-- /published -->

            <!-- item_img -->
            <div class="form-group">
                <label for="item_img">画像</label>
                <input type="file" name="item_img" class="form-control-file">
            </div>
            <!-- /item_img -->

            <!-- 更新ボタン / 戻るボタン -->
            <div class="well well-sm">
                <button type="submit" class="btn btn-success">更新</button>
                <a class="btn btn-link pull-right" href="{{ url('/') }}">戻る</a>
            </div>
            <!-- /更新ボタン / 戻るボタン -->

            <!-- idを送信 -->
            <input type="hidden" name="id" value="{{ $book->id }}">
            <!-- /idを送信 -->

            @csrf
        </form>
    </div>
</div>
@endsection
