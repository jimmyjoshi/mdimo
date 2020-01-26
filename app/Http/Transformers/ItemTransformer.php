<?php
namespace App\Http\Transformers;

use App\Http\Transformers;
use URL;

class ItemTransformer extends Transformer
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
            "item_id"           => (int) $item->id, 
            "user_id"           => (int) $item->user_id, 
            "enterprise_id"     => (int) $item->enterprise_id, 
            "food_category_id"  => (int) $item->food_category_id, 
            "category_title"    => isset($item->category) ? $item->category['food_short_name'] : '',
            "food_short_name"   => $this->nulltoBlank($item->food_short_name),
            "food_description"  => $this->nulltoBlank($item->food_description),
            "price_currency"    => $this->nulltoBlank($item->price_currency),
            "price_with_tax"    => number_format($item->price_with_tax, 2),
            "price_without_tax" => number_format($item->price_without_tax, 2),
            "food_image"        => URL('img/item/'. $item->food_image)
        ];
    }
}