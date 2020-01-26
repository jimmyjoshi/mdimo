<?php namespace App\Models\Item;

/**
 * Class Item
 *
 * @author Anuj Jaha ( er.anujjaha@gmail.com)
 */

use App\Models\BaseModel;
use App\Models\Item\Traits\Attribute\Attribute;
use App\Models\Item\Traits\Relationship\Relationship;

class Item extends BaseModel
{
    use Attribute, Relationship;
    /**
     * Database Table
     *
     */
    protected $table = "data_food_item_detail";

    /**
     * Fillable Database Fields
     *
     */
    protected $fillable = [
        "id", "user_id", "enterprise_id", "food_category_id", "food_short_name", "food_description", "price_with_tax", "price_without_tax", "food_image", "is_active", "created_at", "updated_at", 
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