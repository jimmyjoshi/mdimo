<?php namespace App\Models\QueueMember;

/**
 * Class QueueMember
 *
 * @author Anuj Jaha ( er.anujjaha@gmail.com)
 */

use App\Models\BaseModel;
use App\Models\QueueMember\Traits\Attribute\Attribute;
use App\Models\QueueMember\Traits\Relationship\Relationship;

class QueueMember extends BaseModel
{
    use Attribute, Relationship;
    /**
     * Database Table
     *
     */
    protected $table = "data_queue_members";

    /**
     * Fillable Database Fields
     *
     */
    protected $fillable = [
        "id", "queue_id", "store_id", "user_id", "user_name", "queue_number", "member_count", "processed_number", "processed_at", "description", "is_active", "created_at", "updated_at", 
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