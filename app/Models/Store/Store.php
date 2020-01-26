<?php namespace App\Models\Store;

/**
 * Class Store
 *
 * @author Anuj Jaha ( er.anujjaha@gmail.com)
 */

use App\Models\BaseModel;
use App\Models\Store\Traits\Attribute\Attribute;
use App\Models\Store\Traits\Relationship\Relationship;

class Store extends BaseModel
{
    use Attribute, Relationship;
    /**
     * Database Table
     *
     */
    protected $table = "data_enterprise_detail";

    /**
     * Fillable Database Fields
     *
     */
    protected $fillable = [
        "id", "user_id", "title", "description", "address", "city", "state", "zip", "image", "latitude", "longitude", "is_active", "created_at", "updated_at", 
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