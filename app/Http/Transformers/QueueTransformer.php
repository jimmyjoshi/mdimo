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
            "enterprise_id" => $item->store_id, 
            "title"         => $item->title, 
            "qdate"         => date('m/d/Y', strtotime($item->qdate)),
            "members"       => $memberData
        ];
    }

    /**
     * Transform My Queue
     *
     * @param object
     * @return array
     */
    public function transformMyQueue($queueData)
    {
        $queue  = $queueData->queue;
        $user   = $queueData->user;

        return [
            "queue_id"      => (int) $queueData->id, 
            "user_id"       => $queueData->user_id, 
            "enterprise_id" => $queueData->store_id, 
            "title"         => $queue->title, 
            "qdate"         => date('m/d/Y', strtotime($queue->qdate)),
            'name'          => $user->name,
            'phone'         => $user->phone,
            'member_count'  => $queueData->member_count,
            'queue_number'  => $queueData->queue_number,
            "members"        => [
                'user_id'       => $user->id,
                'name'          => $user->name,
                'phone'         => $user->phone,
                'member_count'  => $queueData->member_count,
                'queue_number'  => $queueData->queue_number
            ]
        ];
    }
}