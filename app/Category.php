<?php

namespace App;

use App\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

    protected $dates = ['delete_at'];
    protected $fillable = [
        'name',
        'description',
    ];

/* belongsToMany hace referencia de muchos a muchos en BD*/
    public function products(){ 
        return $this -> belongsToMany(Product::class);
    } 
}
