<?php

namespace App\Http\Controllers\Category;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class CategoryBuyerController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Category $category)
    {
        $buyers = $category->products()
            ->whereHas('transactions') /*muestra los productos que tienen asociada una transaccion*/
            ->with('transactions.buyer') /*relaciones compuestas entre transacciones y sus compradores*/
            ->get()
            ->pluck('transactions')/*para que entre primero a las transacciones*/ 
            ->colapse() /*tomara todas las listas y las juntara en una sola */
            ->pluck('buyer')/*luego entra a compradores*/
            ->unique() /*para que no se repitan los compradores*/
            ->values(); /*reorganiza los indices en orden correcto*/


        return $this->showAll($buyers); //para que muestre todos 
    }
}
