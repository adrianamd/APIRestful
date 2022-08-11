<?php

namespace App\Http\Controllers\Buyer;

use App\Buyer;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class BuyerSellerController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Buyer $buyer)  /*se inserta la dependencia del comprador*/
    {
        $sellers = $buyer->transactions()->with('products.sellers')
        ->get()
        ->pluck('products.sellers')/*para que entre primero a productos y luego a vendedores*/
        ->unique('id') /*para que no se repitan los vendedores*/
        ->values(); /*reorganiza los indices en orden correcto*/

        return $this->showAll($sellers);
    }
}
