<?php namespace App\Models\Order\Traits\Relationship;

use App\Models\OrderDetail\OrderDetail;

trait Relationship
{
	/**
	 * @return mixed
	 */
	public function order_details()
	{
	    return $this->hasMany(OrderDetail::class, 'order_id');
	}
}