<?php

namespace App\Http\Controllers\Product;

use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class ProductBuyerController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Product $product)
    {
        $buyers = $product->transactions()
        ->with('buyer') /*se obtienen las relaciones que tengan compradores de algun producto */
        ->get()
        ->pluck('buyer') /*junta en una sola lista los resultados que tienen compradores*/
        ->unique('id') /*para que no se repitan los compradores*/
        ->values();

        return $this->showAll($buyers);
    }

}
