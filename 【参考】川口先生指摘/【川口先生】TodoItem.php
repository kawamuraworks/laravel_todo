<?php

namespace App;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Builder;
use App\Scopes\ScopeTodoItem;
use \Carbon\Carbon;


class TodoItem extends Model
{
    use Notifiable;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'item_name', 'registration_date', 'expire_date', 'finished_date', 'is_deleted'
    ];


    /*「【備忘録】todo_items」と「users」のテーブルを結合する */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /* 【課題】コントローラで書き過ぎてModelを活かしていない？
    public function searchItems(Request $request, $input)
    {
        $items = TodoItem::whereHas('user', function($q) use($input){
            $q->where('family_name','like','%'.$input.'%')
            ->orWhere('first_name', 'like', '%' . $input . '%')
            ->orWhere('item_name', 'like', '%' . $input . '%');
        })->get();
        return $this->$items;
    }
    */
    /* 追加しております 川口 */
    public function search($request,$input,$sort){
      $user = Auth::user();
      $items = TodoItem::whereHas('user', function($q) use($input, $sort){
          $q->where('family_name','like','%'.$input.'%')
          ->orWhere('first_name', 'like', '%' . $input . '%')
          ->orWhere('item_name', 'like', '%' . $input . '%')
          ->orderBy($sort, 'asc');
      })->paginate(5);
      return $items;
    }

}
