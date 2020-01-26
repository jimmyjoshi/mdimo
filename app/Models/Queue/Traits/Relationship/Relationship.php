<?php namespace App\Models\Queue\Traits\Relationship;

use App\Models\QueueMember\QueueMember;

trait Relationship
{
	/**
	 * @return mixed
	 */
	public function members()
	{
	    return $this->hasMany(QueueMember::class, 'queue_id');
	}
}