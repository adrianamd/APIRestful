<?php

namespace App\Http\Controllers\Category;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class CategorySellerController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Category $category)
    {
        $sellers = $category->products()->with('seller')
            ->get()
            ->pluck('seller')/*para que entre primero a productos y luego a vendedores*/ 
            ->unique() /*para que no se repitan los vendedores*/
            ->values(); /*reorganiza los indices en orden correcto para que no queden objetos vacios*/

        return $this->showAll($sellers); //para que muestre todos 
    }
}
