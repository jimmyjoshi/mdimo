<?php namespace App\Models\Queue;

/**
 * Class Queue
 *
 * @author Anuj Jaha ( er.anujjaha@gmail.com)
 */

use App\Models\BaseModel;
use App\Models\Queue\Traits\Attribute\Attribute;
use App\Models\Queue\Traits\Relationship\Relationship;

class Queue extends BaseModel
{
    use Attribute, Relationship;
    /**
     * Database Table
     *
     */
    protected $table = "data_queues";

    /**
     * Fillable Database Fields
     *
     */
    protected $fillable = [
        "id", "user_id", "store_id", "title", "description", "qdate", "is_active", "created_at", "updated_at", 
    ];

    /**
     * Timestamp flag
     *
     */
    public $timestamps = true;

    /**
     * Guarded ID Column
     *
     */
    protected $guarded = ["id"];
}