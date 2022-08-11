<?php

namespace App\Http\Controllers\Seller;

use App\Seller;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class SellerTransactionController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Seller $seller)
    {
        $transactions = $seller->products()
            ->whereHas('transactions') /*muestra los productos que tienen asociada una transaccion*/
            ->with('transactions') /*se obtienen esas transacciones*/
            ->get() 
            ->pluck('transactions')/*para que entre primero a productos y luego a vendedores*/ 
            ->colapse(); /*tomara todas las listas y las juntara en una sola */

        return $this->showAll($transactions); //para que muestre todos
    }
}
