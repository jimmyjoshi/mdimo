<?php namespace App\Models\QueueMember\Traits\Relationship;

use App\Models\Queue\Queue;
use App\Models\Access\User\User;

trait Relationship
{
	/**
	 * @return mixed
	 */
	public function queue()
	{
		return $this->belongsTo(Queue::class);
	}

	/**
	 * @return mixed
	 */
	public function user()
	{
		return $this->belongsTo(User::class);
	}
}