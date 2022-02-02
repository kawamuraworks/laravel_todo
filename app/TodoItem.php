<?php

namespace App;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Scopes\ScopeTodoItem;

class TodoItem extends Model
{
    /* GlobalScopeは後で
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new ScopeTodoItem);
    }
    */

    // 「todo_items」と「users」のテーブルを結合する
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function test()
    {
        return $this->hasMany('App\User', 'user_id', 'id');
    }

    public function searchItems(Request $request)
    {
        $r = $request->input;

        $items = TodoItem::whereHas('user', function($q) use($r){
            $q->where('family_name','like','%'.$r.'%')
            ->orWhere('first_name', 'like', '%' . $r . '%')
            ->orWhere('item_name', 'like', '%' . $r . '%');
        })->get();
        return $items;
    }

    public function findNull()
    {
        $input = '';
        return $this->$input;
    }

}
