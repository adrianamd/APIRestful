<?php

namespace App\Scopes;

use Ilumante\Database\Eloquent\Model;
use Ilumante\Database\Eloquent\Scope;
use Ilumante\Database\Eloquent\Builder;

class BuyerScope implements Scope{

	public function apply(Builder $builder, Model $model){

		$builder->has('transactions');

	}
}