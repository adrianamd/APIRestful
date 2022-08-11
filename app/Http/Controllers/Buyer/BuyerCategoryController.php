<?php

namespace App\Http\Controllers\Buyer;

use App\Buyer;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class BuyerCategoryController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Buyer $buyer) /*se inserta la dependencia del comprador*/
    {
        $sellers = $buyer->transactions()->with('products.categories')
            ->get()
            ->pluck('products.categories')/*para que entre primero a productos y luego a vendedores*/ 
            ->colapse() /*tomara todas las listas y las juntara en una sola */
            ->unique('id') /*para que no se repitan los vendedores*/
            ->values(); /*reorganiza los indices en orden correcto para que no queden objetos vacios*/

        return $this->showAll($sellers);
    }
}
