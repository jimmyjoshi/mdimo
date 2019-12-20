<?php
namespace App\Http\Transformers;

use App\Http\Transformers;

class TestTransformer extends Transformer
{
    /**
     * Transform
     *
     * @param array $data
     * @return array
     */
    public function transform($item)
    {
        if(is_array($item))
        {
            $item = (object)$item;
        }

        return [
            "testId" => (int) $item->id, "testName" =>  $item->name, "testAge" =>  $item->age, "testValue" =>  $item->value, 
        ];
    }
}