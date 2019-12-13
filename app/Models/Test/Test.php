<?php namespace App\Models\Test;

/**
 * Class Test
 *
 * @author Anuj Jaha ( er.anujjaha@gmail.com)
 */

use App\Models\BaseModel;
use App\Models\Test\Traits\Attribute\Attribute;
use App\Models\Test\Traits\Relationship\Relationship;

class Test extends BaseModel
{
    use Attribute, Relationship;
    /**
     * Database Table
     *
     */
    protected $table = "test";

    /**
     * Fillable Database Fields
     *
     */
    protected $fillable = [
        "id", "name", "age", "value", 
    ];

    /**
     * Timestamp flag
     *
     */
    public $timestamps = false;

    /**
     * Guarded ID Column
     *
     */
    protected $guarded = ["id"];
}