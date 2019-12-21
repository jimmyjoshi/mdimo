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
            "store_id"          => (int) $item->store_id, 
            "category_id"       => (int) $item->category_id, 
            "category_title"    => isset($item->category) ? $item->category['title'] : '',
            "title"             => $this->nulltoBlank($item->title),
            "description"       => $this->nulltoBlank($item->description),
            "price_with_tax"    => (float) number_format($item->price_with_tax, 2),
            "price_without_tax" => (float) number_format($item->price_without_tax, 2),
            "image"             => URL('img/item/'. $item->image)
        ];
    }
}