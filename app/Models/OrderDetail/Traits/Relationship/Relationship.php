<?php namespace App\Models\OrderDetail\Traits\Relationship;

use App\Models\Category\Category;
use App\Models\Item\Item;

trait Relationship
{
	/**
	 * @return mixed
	 */
	public function category()
	{
	    return $this->belongsTo(Category::class, 'category_id');
	}

	/**
	 * @return mixed
	 */
	public function item()
	{
	    return $this->belongsTo(Item::class, 'item_id');
	}
}