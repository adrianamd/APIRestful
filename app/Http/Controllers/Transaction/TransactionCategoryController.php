<?php

namespace App\Http\Controllers\Transaction;

use App\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class TransactionCategoryController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($transaction)
    { /*para consulta en postman es con el metodo get (apirestful.dev/transactions/id/categories)*/
        $categories = $transaction->product->categories;
        return $this->showAll($categories);
    }
}
