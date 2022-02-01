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

    public function findNull()
    {
        $input = '';
        return $this->$input;
    }

}
