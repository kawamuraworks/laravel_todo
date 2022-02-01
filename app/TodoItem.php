<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;


class TodoItem extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }

}
