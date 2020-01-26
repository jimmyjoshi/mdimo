<?php namespace App\Models\OrderDetail\Traits\Relationship;

use App\Models\Category\Category;

trait Relationship
{
	/**
	 * @return mixed
	 */
	public function category()
	{
	    return $this->belongsTo(Category::class, 'category_id');
	}
}