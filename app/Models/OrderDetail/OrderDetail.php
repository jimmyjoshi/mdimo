<?php namespace App\Models\OrderDetail;

/**
 * Class OrderDetail
 *
 * @author Anuj Jaha ( er.anujjaha@gmail.com)
 */

use App\Models\BaseModel;
use App\Models\OrderDetail\Traits\Attribute\Attribute;
use App\Models\OrderDetail\Traits\Relationship\Relationship;

class OrderDetail extends BaseModel
{
    use Attribute, Relationship;
    /**
     * Database Table
     *
     */
    protected $table = "data_order_details";

    /**
     * Fillable Database Fields
     *
     */
    protected $fillable = [
        "id", "order_id", "item_id", "category_id", "title", "qty", "price_with_tax", "price_without_tax", "notes", "image", "created_at", "updated_at", 
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