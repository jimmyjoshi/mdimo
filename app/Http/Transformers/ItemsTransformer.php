<?php
namespace App\Http\Transformers;

use App\Http\Transformers;

class ItemsTransformer extends Transformer
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
            "itemsId" => (int) $item->id, "itemsUserId" =>  $item->user_id, "itemsStoreId" =>  $item->store_id, "itemsCategoryId" =>  $item->category_id, "itemsTitle" =>  $item->title, "itemsDescription" =>  $item->description, "itemsPriceWithTax" =>  $item->price_with_tax, "itemsPriceWithoutTax" =>  $item->price_without_tax, "itemsImage" =>  $item->image, "itemsIsActive" =>  $item->is_active, "itemsCreatedAt" =>  $item->created_at, "itemsUpdatedAt" =>  $item->updated_at, 
        ];
    }
}