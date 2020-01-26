<?php
namespace App\Http\Transformers;

use App\Http\Transformers;

class CategoryTransformer extends Transformer
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
            "category_id"   => (int) $item->id,
            "title"         => $item->food_short_name, 
            "description"   => $this->nulltoBlank($item->food_description)
        ];
    }
}