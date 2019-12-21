<?php namespace App\Models\Store\Traits\Relationship;

use App\Models\Access\User\User;

trait Relationship
{
	/**
	 * Many-to-Many relations with Role.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function user()
	{
	    return $this->belongsTo(User::class, 'user_id');
	}
}