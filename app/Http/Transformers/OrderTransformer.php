<?php
namespace App\Http\Transformers;

use App\Http\Transformers;

class OrderTransformer extends Transformer
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

        $itemDetails = [];

        if($item->order_details)
        {
            foreach($item->order_details as $detail)
            {
                $itemDetails[] = [
                    'order_item_id'     => (int) $detail->id,
                    'item_id'           => (int) $detail->item_id,
                    'category_id'       => (int) $detail->category_id,
                    "category_title"    => isset($detail->category) ? $detail->category['title'] : '',
                    'title'             => $detail->title,

                    'qty'               => $detail->qty,
                    'price_with_tax'    => number_format($detail->price_with_tax, 2),
                    'price_without_tax' => number_format($detail->price_without_tax, 2),
                    "image"             => URL('img/item/'. $detail->image)

                ];
            }
        }

        return [
            "order_id"      => (int) $item->id,
            "user_id"       => $item->user_id, 
            "store_id"      => $item->store_id, 
            "queue_id"      => $item->queue_id,
            "order_items"   => $itemDetails
        ];
    }
}