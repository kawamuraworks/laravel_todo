<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\TodoItem;
use Illuminate\Database\Eloquent\Builder;


class TodolistController extends Controller
{
    public function index(Request $request, Builder $builder)
    {
        $user = Auth::user();
        $items = TodoItem::all();
        $param = ['items' => $items, 'user' => $user];

        return view('todo_list.index', $param);
    }

    public function post()
    {
        return view('todo_list.index');
    }

    public function search()
    {
        return view('todo_list.index');
    }

    public function entry()
    {
        return view('todo_list.entry');
    }

    public function create(Request $request)
    {
        $param = [
            'user_id' => $request->user_id,
            'item_name' => $request->item_name,
            'registration_date' => $request->registration_date,
            'expire_date' => $request->expire_date,
            'finished_date' => $request->finished_date,
            'is_deleted' => $request->is_deleted,

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
