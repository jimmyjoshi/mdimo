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
            "categoryId" => (int) $item->id, "categoryTitle" =>  $item->title, "categoryDescription" =>  $item->description, "categoryImage" =>  $item->image, "categoryIsActive" =>  $item->is_active, "categoryCreatedAt" =>  $item->created_at, "categoryUpdatedAt" =>  $item->updated_at, 
        ];
    }
}