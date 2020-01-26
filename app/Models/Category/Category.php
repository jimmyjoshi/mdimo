<?php namespace App\Models\Category;

/**
 * Class Category
 *
 * @author Anuj Jaha ( er.anujjaha@gmail.com)
 */

use App\Models\BaseModel;
use App\Models\Category\Traits\Attribute\Attribute;
use App\Models\Category\Traits\Relationship\Relationship;

class Category extends BaseModel
{
    use Attribute, Relationship;
    /**
     * Database Table
     *
     */
    protected $table = "data_food_category";

    /**
     * Fillable Database Fields
     *
     */
    protected $fillable = [
        "id", "title", "description", "image", "is_active", "created_at", "updated_at", 
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