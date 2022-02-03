<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use \Carbon\Carbon;
use App\TodoItem;
use App\User;
use Illuminate\Database\Eloquent\Builder;


class TodolistController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $items = TodoItem::all();
        $input = '';
        $param = ['items' => $items, 'user' => $user, 'input' => $input];

        return view('todo_list.index', $param);
    }

    public function post()
    {
        return view('todo_list.index');
    }

    // public function find(Request $request)
    // {
    //     $user = Auth::user();
    //     $input = TodoItem::findNull();
    //     $param = ['user' => $user, 'input' => $input];
    //     return view('todo_list.search', $param);
    // }

    public function search(Request $request)
    {
        $user = Auth::user();
        $input = $request->input;
        $items = TodoItem::whereHas('user', function($q) use($input){
            $q->where('family_name','like','%'.$input.'%')
            ->orWhere('first_name', 'like', '%' . $input . '%')
            ->orWhere('item_name', 'like', '%' . $input . '%');
        })->get();
        $param = ['user' => $user, 'items' => $items, 'input' => $request->input];
        return view('todo_list.search', $param);
        /*【備忘録】検索方法
        ①whereHas内でrequestを扱うために$inputを定義
        ②whereHasでTodoItemモデルで「users」と「todo_items」テーブルを連携した関数を呼び出し
        ③where,orWhereで検索
        ④空欄で検索した場合は、$input==nullとなるのでどんな文字でもよいということになり全ての値を表示する。
        */
    }

    public function entry()
    {
        $user = Auth::user();
        $user_list = User::all();
        $items = TodoItem::all();
        $input = '';
        $param = ['user' => $user, 'user_list' => $user_list, 'items' => $items, 'input' => $input];

        return view('todo_list.entry', $param);
    }

    public function create(Request $request)
    {
        $param = [
            'user_id' => $request->user_id,
            'item_name' => $request->item_name,
            'registration_date' => Carbon::today(),
            'expire_date' => $request->expire_date,
            'finished_date' => NULL,
            'is_deleted' => 0,

        ];
        DB::table('todo_items')->insert($param);

        return redirect('/todo_list');
    }

    public function edit(Request $request)
    {
        $item = DB::table('todo_items')
            ->where('id', $request->id)->first();

        return view('todo_list.edit', ['form' => $item]);
    }

    public function update(Request $request)
    {
        $param = [
            'user_id' => $request->user_id,
            'item_name' => $request->item_name,
            'registration_date' => $request->registration_date,
            'expire_date' => $request->expire_date,
            'finished_date' => $request->finished_date,
            'is_deleted' => $request->is_deleted,

        ];
        DB::table('todo_items')
            ->where('id', $request->id) // 【絶対注意】updateする値をwhereで指定しないと全てを上書きしてしまう。
            ->update($param);

        return redirect('/todo_list');
    }

    public function del(Request $request)
    {
        $item = DB::table('todo_items')
            ->where('id', $request->id)->first();

        return view('todo_list', ['form' => $item]);
    }

    public function remove(Request $request)
    {
        DB::table('todo_list')
            ->where('id', $request->id) // 【絶対注意】deleteする値をwhereで指定しないと全てを削除してしまう。
            ->delete();

        return redirect('/todo_list');
    }
}
