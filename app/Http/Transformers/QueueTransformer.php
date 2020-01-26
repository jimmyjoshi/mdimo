<?php
namespace App\Http\Transformers;

use App\Http\Transformers;

class QueueTransformer extends Transformer
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

        $memberData = [];

        if(isset($item->members) && count($item->members))
        {
            foreach($item->members as $member)
            {
                if($member->processed_at == null)
                {
                    $memberData[] = [
                        'user_id'       => $member->user_id,
                        'name'          => $member->user->name,
                        'phone'         => $member->user->phone,
                        'member_count'  => $member->member_count,
                        'queue_number'  => $member->queue_number
                    ];
                }
            }
        }

        return [
            "queue_id"      => (int) $item->id, 
            "user_id"       => $item->user_id, 
            "store_id"      => $item->store_id, 
            "title"         => $item->title, 
            "qdate"         => date('m/d/Y', strtotime($item->qdate)),
            "members"       => $memberData
        ];
    }
}