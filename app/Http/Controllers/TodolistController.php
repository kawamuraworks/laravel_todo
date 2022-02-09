<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use \Carbon\Carbon;
use App\TodoItem;
use App\User;
use App\Http\Requests\TodolistRequest;

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

    public function action(Request $request)
    {
        $item = TodoItem::where('id', $request->id)->first();// 【備忘録】->first()でitemのデータを取り出さないとエラーになる。
        $form = $request->all();
        unset($form['_token']);
        $item->fill($form)->save();

        return redirect('/todo_list');
    }

    public function search(Request $request)
    {
        $user = Auth::user();
        $today = Carbon::today();
        $input = $request->input;
        $sort = 'expire_date';
        $items = TodoItem::search($request,$input,$sort);
        // TodoItemモデルにサーチ関数を追加。newでTodoItemにある関数を全て呼び出す
        // $items = new TodoItem();
        // // TodoItemモデルのサーチ関数に($request,$input,$sort)の値を渡す。
        // $items = $items -> search($request,$input,$sort);
        // 検索された値を画面に保持させます 川口
        $param = ['user' => $user, 'items' => $items, 'input' => $request->input, 'sort' => $sort, 'today' => $today];
        return view('todo_list.search', $param);
    }
        /*【備忘録】関数の呼び出しについて
        Model内で「public static function」とした場合は、TodoItem::search()と直接呼びだせる。
        「public function」とした場合は、
            ①$items = new TodoItem();
            ②$items = $items -> search($request,$input,$sort);
        というように2段階で呼び出しをする必要がある。
        */

        /*【備忘録】検索方法
        ①whereHas内でrequestを扱うために$inputを定義
        ②whereHasでTodoItemモデルで「users」と「todo_items」テーブルを連携した関数を呼び出し
        ③where,orWhereで検索
        ④空欄で検索した場合は、$input==nullとなるのでどんな文字でもよいということになり全ての値を表示する。
        */

        /* 【備忘録】コントローラで検索する方法（河村作成）
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
        */

    public function entry()
    {
        $user = Auth::user();
        $user_list = User::all();
        $items = TodoItem::all();
        $input = 'entry';
        $param = ['user' => $user, 'user_list' => $user_list, 'items' => $items, 'input' => $input];

        return view('todo_list.entry', $param);
    }

    public function create(TodolistRequest $request,)
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
        /*
        【備忘録】Modelを使用せずにControllerでDBに書き込む方法
                SQL文でDBに登録するため、timestampの内容は反映されない。
                timestampを登録するにはfill()->save()としなければならない。
        */
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

    public function update(TodolistRequest $request)
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

    public function getLogout()
    {
        Auth::logout();
        return redirect('/todo_list');
    }

}
