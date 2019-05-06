<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
     protected $fillable = [
        'name', 'detail', 'discount','price','stock'
    ];
     
    public function reviews(){
        return $this->hasMany('App\Review');
    }
}
