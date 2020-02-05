<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PackageDetails extends Model
{
    protected $guarded=[];

    public function packageItem()
    {
        return $this->hasOne(Item::class, 'id', 'item_id');
    }

}
