<?php

namespace App;

use App\Seller;
use App\Category;
use App\Transaction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    const PRODUCTO_DISPONIBLE = 'disponible';
    const PRODUCTO_NO_DISPONIBLE = 'no disponible';

    protected $dates = ['delete_at'];
    protected $fillable = [
       'name',
       'description',
       'quantity',
       'status',
       'image',
       'seller_id',
    ];

    /*ocultar la tabla pivot al hacer la consulta en postman*/
    protected $hidden = [   
        'pivot'
    ];

    public function estaDisponible(){
       return $this -> status == Product::PRODUCTO_DISPONIBLE;
    }
 
 /*belongsTo hace referencia a de uno a muchos en BD*/
    public function seller(){
      return $this -> belongsTo(Seller::class);
    }

    public function transactions(){
      return $this -> hasMany(Transaction::class);
    }

    public function categories(){
      return $this -> belongsToMany(Category::class);
    }
}
