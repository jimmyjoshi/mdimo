<?php
namespace App\Http\Transformers;

use App\Http\Transformers;
use URL;

class StoreTransformer extends Transformer
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
            "store_id"      => (int) $item->id, 
            "user_id"       => $item->user_id, 
            "title"         => $item->title, 
            "description"   => $item->description, 
            "address"       => $item->address, 
            "city"          => $item->city, 
            "state"         => $item->state, 
            "zip"           => $item->zip, 
            "image"         => URL('img/store/'. $item->image), 
            "latitude"      => $item->latitude, 
            "longitude"     =>  $item->longitude
        ];
    }
}