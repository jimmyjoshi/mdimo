<?php
namespace App\Http\Transformers;

use App\Http\Transformers;

class PermissionTransformer extends Transformer
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
            "permissionId" => (int) $item->id, "permissionName" =>  $item->name, "permissionDisplayName" =>  $item->display_name, "permissionSort" =>  $item->sort, "permissionCreatedAt" =>  $item->created_at, "permissionUpdatedAt" =>  $item->updated_at, 
        ];
    }
}