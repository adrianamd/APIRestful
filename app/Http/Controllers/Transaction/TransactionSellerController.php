<?php

namespace App\Http\Controllers\Transaction;

use App\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class TransactionSellerController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Transaction $transaction)
    { /*para consulta en postman es con el metodo get (apirestful.dev/transactions/id/seller)*/
        $seller = $transaction->product->seller;
        return $this->showAll($seller);
    }
}
