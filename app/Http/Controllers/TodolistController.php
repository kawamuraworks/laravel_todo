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
        $today = Carbon::today();
        $sort = 'expire_date';
        $items = TodoItem::orderBy($sort, 'asc')->paginate(5);
        $input = '';
        $param = [ 'user' => $user, 'sort' => $sort, 'items' => $items, 'input' => $input, 'today' => $today];

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
        $today = Carbon::today();
        $input = $request->input;
        $sort = 'expire_date';
        $items = TodoItem::whereHas('user', function($q) use($input, $sort){
            $q->where('family_name','like','%'.$input.'%')
            ->orWhere('first_name', 'like', '%' . $input . '%')
            ->orWhere('item_name', 'like', '%' . $input . '%')
            ->orderBy($sort, 'asc');
        })->paginate(5);
        $param = ['user' => $user, 'items' => $items, 'input' => $request->input, 'sort' => $sort, 'today' => $today];
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
        $input = 'entry';
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
        $user = Auth::user();
        $user_list = User::all();
        $item = TodoItem::where('id', $request->id)->first();
        $today = Carbon::today();
        $input = 'edit';
        $param = ['user' => $user, 'user_list' => $user_list, 'item' => $item, 'today' => $today, 'input' => $input];

        return view('todo_list.edit', $param);
    }

    public function update(Request $request)
    {
        $item = TodoItem::where('id', $request->id)->first();// 【備忘録】->first()でitemのデータを取り出さないとエラーになる。
        $form = $request->all();
        unset($form['_token']);
        $item->fill($form)->save();

        return redirect('/todo_list');
    }

    public function del(Request $request)
    {
        $user = Auth::user();
        $user_list = User::all();
        $item = TodoItem::where('id', $request->id)->first();
        $today = Carbon::today();
        $input = 'del';
        $param = ['user' => $user, 'user_list' => $user_list, 'item' => $item, 'today' => $today, 'input' => $input];

        return view('todo_list.del', $param);
    }

    public function remove(Request $request)
    {
        TodoItem::where('id', $request->id)->delete();
        return redirect('/todo_list');
    }

    public function getAuth(Request $request)
    {
        $param = ['message' => 'ログインして下さい。'];
        return view('todo_list.auth', $param);
    }

    public function postAuth(Request $request)
    {
        $email = $request->email;
        $password = $request->password;

        if (Auth::attempt(['email' => $email, 'password' => $password])) {
            $msg = 'ログインしました。(' . Auth::user()->name . ')';
        } else {
            $msg = 'ログインに失敗しました。';
        }

        return view('todo_list.auth', ['message' => $msg]);
    }

}
