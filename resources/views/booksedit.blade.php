@extends('layouts.app')
@section('content')
<div class="rowcontainer">
    <div class="col-md-12">
    @include('common.errors')
    <form enctype="multipart/form-data" action="{{ url('books/update') }}" method="POST">
        <!--item_name-->
        <div class="form-group">
            <label for="item_name">Title</label>
            <input type="text" name="item_name" class="form-control" value="{{$book->item_name}}">
        </div>
        <!--/ item_name-->

        <!--item_number-->
        <div class="form-group">
            <label for="item_number">Number</label>
            <input type="text" name="item_number" class="form-control" value="{{$book->item_number}}">
        </div>
        <!--/ item_number-->
        <!--item_amount-->
        <div class="form-group">
            <label for="item_amount">Amount</label>
            <input type="text" name="item_amount" class="form-control" value="{{$book->item_amount}}">
        </div>
        <!--/ item_amount-->
        <!--published-->
        <div class="form-group">
            <label for="published" name="published">Published</label>
            <input type="datetime" name="published" class="form-control" value="{{$book->published}}"/>
        </div>
        <!--/ published-->
        <!--画像-->
        <div class="col-sm-6">
            <label>画像</label>
            <input type="file" name="item_img">
        </div>
        <!--/ 画像-->
        <!--更新ボタン/戻るボタン-->
        <div class="well well-sm">
            <button type="submit" class="btn btn-success">更新</button>
            <a class="btn btn-link pull-right" href="{{ url('/') }}">戻る</a>
        </div>
        <!--/ 更新ボタン/戻るボタン-->
        <!--idを送信-->
        <input type="hidden" name="id" value="{{$book->id}}">
        <!--/ idを送信-->
        @csrf
    </form>
    </div>
</div>
@endsection