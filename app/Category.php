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

    /*ocultar la tabla pivot al hacer la consulta en postman*/
    protected $hidden = [   
        'pivot'
    ];

/* belongsToMany hace referencia de muchos a muchos en BD*/
    public function products(){ 
        return $this -> belongsToMany(Product::class);
    } 
}
