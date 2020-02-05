<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $guarded=[];

    public function itemCategory()
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
//        return $this->hasOne(Category::Item, 'category_id');
//      return $this->hasOne('App\Models\Category', 'id');
    }
}
