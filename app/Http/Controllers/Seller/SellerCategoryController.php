<?php

namespace App\Http\Controllers\Seller;

use App\Seller;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class SellerCategoryController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Seller $seller)
    {
        $categories = $seller->products()
            ->with('categories') /*se obtienen esas transacciones*/
            ->get() 
            ->pluck('categories')/*para que entre primero a productos y luego a vendedores*/ 
            ->colapse() /*tomara todas las listas y las juntara en una sola */
            ->unique('id') /*para que no se repitan las categorias por medio del id*/
            ->values(); /*reorganiza los indices en orden correcto para que no queden objetos vacios*/

        return $this->showAll($categories); //para que muestre todos
    }
}
