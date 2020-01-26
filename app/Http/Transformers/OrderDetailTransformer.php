<?php
namespace App\Http\Transformers;

use App\Http\Transformers;

class OrderDetailTransformer extends Transformer
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
            "orderdetailId" => (int) $item->id, "orderdetailOrderId" =>  $item->order_id, "orderdetailItemId" =>  $item->item_id, "orderdetailCategoryId" =>  $item->category_id, "orderdetailTitle" =>  $item->title, "orderdetailQty" =>  $item->qty, "orderdetailPriceWithTax" =>  $item->price_with_tax, "orderdetailPriceWithoutTax" =>  $item->price_without_tax, "orderdetailNotes" =>  $item->notes, "orderdetailImage" =>  $item->image, "orderdetailCreatedAt" =>  $item->created_at, "orderdetailUpdatedAt" =>  $item->updated_at, 
        ];
    }
}