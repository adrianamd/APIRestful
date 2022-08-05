<?php

namespace App;

use App\Product;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
        'description',
    ];

/* belongsToMany hace referencia de muchos a muchos en BD*/
    public function products(){ 
        return $this -> belongsToMany(Product::class);
    } 
}
