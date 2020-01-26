<?php namespace App\Models\Order;

/**
 * Class Order
 *
 * @author Anuj Jaha ( er.anujjaha@gmail.com)
 */

use App\Models\BaseModel;
use App\Models\Order\Traits\Attribute\Attribute;
use App\Models\Order\Traits\Relationship\Relationship;

class Order extends BaseModel
{
    use Attribute, Relationship;
    /**
     * Database Table
     *
     */
    protected $table = "data_orders";

    /**
     * Fillable Database Fields
     *
     */
    protected $fillable = [
        "id", "user_id", "store_id", "queue_id", "processed_by", "title", "notes", "status", "processed_at", "created_at", "updated_at", 
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