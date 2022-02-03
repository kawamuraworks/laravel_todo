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

    public function searchItems(Request $request)
    {
        $input = $request->input;
        $items = TodoItem::whereHas('user', function($q) use($input){
            $q->where('family_name','like','%'.$input.'%')
            ->orWhere('first_name', 'like', '%' . $input . '%')
            ->orWhere('item_name', 'like', '%' . $input . '%');
        })->get();
        return $this->$items;
    }

}
