<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class Book extends Model
{
    protected $fillable = ['user_id', 'id', 'item_name', 'item_number', 'item_amount', 'published', 'item_img'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function getBooksByUserId($userId)
    {
        return self::with('user')
            ->where('user_id', $userId)
            ->orderBy('created_at', 'asc')
            ->paginate(3);
    }

    public static function getBookByUserId($bookId, $userId)
    {
        return self::where('user_id', $userId)
            ->find($bookId);
    }

    public static function validate($data)
    {
        return Validator::make($data, self::rules(), self::messages());
    }

    public static function rules()
    {
        return [
            'item_name' => 'required|min:3|max:255',
            'item_number' => 'required|min:1|max:3',
            'item_amount' => 'required|max:6',
            'published' => 'required',
        ];
    }

    public static function messages()
    {
        return [
            'item_name.required' => 'アイテム名は必須項目です。',
            'item_name.min' => 'アイテム名は3文字以上で入力してください。',
            'item_name.max' => 'アイテム名は255文字以内で入力してください。',
            'item_number.required' => 'アイテム番号は必須項目です。',
            'item_number.min' => 'アイテム番号は1桁以上で入力してください。',
            'item_number.max' => 'アイテム番号は3桁以内で入力してください。',
            'item_amount.required' => 'アイテム数は必須項目です。',
            'item_amount.max' => 'アイテム数は6桁以内で入力してください。',
            'published.required' => '公開フラグは必須項目です。',
        ];
    }

    public static function searchBooksByUserId($userId, $search)
    {
        return self::with('user')
            ->where('user_id', $userId)
            ->where(function ($query) use ($search) {
                $query->where('item_name', 'like', '%' . $search . '%')
                    ->orWhere('item_amount', 'like', '%' . $search . '%')
                    ->orWhere('item_number', 'like', '%' . $search . '%');
            })
            ->orderBy('created_at', 'asc')
            ->paginate(3);
    }
}

