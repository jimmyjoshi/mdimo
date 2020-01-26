<?php namespace App\Models\Item\Traits\Relationship;

use App\Models\Category\Category;

trait Relationship
{
	/**
	 * @return mixed
	 */
	public function category()
	{
	    return $this->belongsTo(Category::class, 'food_category_id');
	}
}