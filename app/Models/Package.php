<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{

    protected $table ="packages";

    protected $guarded=[];

public  function  packageDetails()
{
    return $this->hasMany(PackageDetails::class);
}

}
