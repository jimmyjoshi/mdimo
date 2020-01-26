<?php
namespace App\Http\Transformers;

use App\Http\Transformers;

class QueueMemberTransformer extends Transformer
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
            "queuememberId" => (int) $item->id, "queuememberQueueId" =>  $item->queue_id, "queuememberStoreId" =>  $item->store_id, "queuememberUserId" =>  $item->user_id, "queuememberQueueNumber" =>  $item->queue_number, "queuememberMemberCount" =>  $item->member_count, "queuememberProcessedNumber" =>  $item->processed_number, "queuememberProcessedAt" =>  $item->processed_at, "queuememberDescription" =>  $item->description, "queuememberIsActive" =>  $item->is_active, "queuememberCreatedAt" =>  $item->created_at, "queuememberUpdatedAt" =>  $item->updated_at, 
        ];
    }
}