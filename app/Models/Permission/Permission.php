<?php namespace App\Models\Permission;

/**
 * Class Permission
 *
 * @author Anuj Jaha ( er.anujjaha@gmail.com)
 */

use App\Models\BaseModel;
use App\Models\Permission\Traits\Attribute\Attribute;
use App\Models\Permission\Traits\Relationship\Relationship;

class Permission extends BaseModel
{
    use Attribute, Relationship;
    /**
     * Database Table
     *
     */
    protected $table = "permissions";

    /**
     * Fillable Database Fields
     *
     */
    protected $fillable = [
        "id", "name", "display_name", "sort", "created_at", "updated_at", 
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