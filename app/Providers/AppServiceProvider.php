<?php

namespace App\Providers;

use App\Product;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        /*cuando se actualice el producto se hace un llamado*/
        Product::updated(function($product){
            if ($product->quantity == 0 && $product->estaDisponible()) {/*valida primero si la cantidad del producto llego a cero y cambia el estado*/
                $product->status = Product:: PRODUCTO_NO_DISPONIBLE;
                $product->save(); /*guarda los cambios*/
            }
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
