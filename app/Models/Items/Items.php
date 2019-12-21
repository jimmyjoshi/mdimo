<?php namespace App\Models\Items;

/**
 * Class Items
 *
 * @author Anuj Jaha ( er.anujjaha@gmail.com)
 */

use App\Models\BaseModel;
use App\Models\Items\Traits\Attribute\Attribute;
use App\Models\Items\Traits\Relationship\Relationship;

class Items extends BaseModel
{
    use Attribute, Relationship;
    /**
     * Database Table
     *
     */
    protected $table = "data_items";

    /**
     * Fillable Database Fields
     *
     */
    protected $fillable = [
        "id", "user_id", "store_id", "category_id", "title", "description", "price_with_tax", "price_without_tax", "image", "is_active", "created_at", "updated_at", 
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