<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Transformers\QueueTransformer;
use App\Http\Controllers\Api\BaseApiController;
use App\Repositories\Queue\EloquentQueueRepository;
use App\Models\QueueMember\QueueMember;

class APIQueueController extends BaseApiController
{
    /**
     * Queue Transformer
     *
     * @var Object
     */
    protected $queueTransformer;

    /**
     * Repository
     *
     * @var Object
     */
    protected $repository;

    /**
     * PrimaryKey
     *
     * @var string
     */
    protected $primaryKey = 'queueId';

    /**
     * __construct
     *
     */
    public function __construct()
    {
        $this->repository                       = new EloquentQueueRepository();
        $this->queueTransformer = new QueueTransformer();
    }

    /**
     * List of All Queue
     *
     * @param Request $request
     * @return json
     */
    public function index(Request $request)
    {
        if($request->has('enterprise_id'))
        {
            $queueData  = $this->repository->getQueueWithMembers($request->get('enterprise_id'));

            if($queueData && isset($queueData->id))
            {
                $responseData = $this->queueTransformer->transform($queueData);
                return $this->successResponse($responseData);
            }
        }

       
        return $this->setStatusCode(400)->failureResponse([
            'message' => 'Unable to find Queue!'
            ], 'No Queue Found !');
    }

    /**
     * Create
     *
     * @param Request $request
     * @return string
     */
    public function create(Request $request)
    {
        $today = $request->has('today') ? $request->get('today') : date("Y-m-d");
        
        if($request->has('enterprise_id'))
        {
            $input = $request->all();
            $input['today'] = $today;
            /*$input = array_merge($request->all(), [
                'user_id' => access()->user()->id
            ]);*/
            $model = $this->repository->create($input);
        }

        if(isset($model))
        {
            $queueData    = $this->repository->getQueueWithMembers($model->store_id, $model->qdate);
            $responseData = $this->queueTransformer->transform($queueData);

            return $this->successResponse($responseData, 'Queue is Created Successfully');
        }

        return $this->setStatusCode(400)->failureResponse([
            'reason' => 'Invalid Inputs or Member has already Joined Queue'
            ], 'Something went wrong !');
    }

    /**
     * View
     *
     * @param Request $request
     * @return string
     */
    public function show(Request $request)
    {
        $itemId = (int) hasher()->decode($request->get($this->primaryKey));

        if($itemId)
        {
            $itemData = $this->repository->getById($itemId);

            if($itemData)
            {
                $responseData = $this->queueTransformer->transform($itemData);

                return $this->successResponse($responseData, 'View Item');
            }
        }

        return $this->setStatusCode(400)->failureResponse([
            'reason' => 'Invalid Inputs or Item not exists !'
            ], 'Something went wrong !');
    }

    /**
     * Edit
     *
     * @param Request $request
     * @return string
     */
    public function edit(Request $request)
    {
        $itemId = (int) hasher()->decode($request->get($this->primaryKey));

        if($itemId)
        {
            $status = $this->repository->update($itemId, $request->all());

            if($status)
            {
                $itemData       = $this->repository->getById($itemId);
                $responseData   = $this->queueTransformer->transform($itemData);

                return $this->successResponse($responseData, 'Queue is Edited Successfully');
            }
        }

        return $this->setStatusCode(400)->failureResponse([
            'reason' => 'Invalid Inputs'
        ], 'Something went wrong !');
    }

    /**
     * Delete
     *
     * @param Request $request
     * @return string
     */
    public function delete(Request $request)
    {
        $itemId = (int) hasher()->decode($request->get($this->primaryKey));

        if($itemId)
        {
            $status = $this->repository->destroy($itemId);

            if($status)
            {
                return $this->successResponse([
                    'success' => 'Queue Deleted'
                ], 'Queue is Deleted Successfully');
            }
        }

        return $this->setStatusCode(404)->failureResponse([
            'reason' => 'Invalid Inputs'
        ], 'Something went wrong !');
    }

    /**
     * Remove Member
     *
     * @param Request $request
     * @return string
     */
    public function removeMember(Request $request)
    {
        if($request->has('queue_id') && $request->has('user_id'))
        {
            $status = $this->repository->removeQueueMember($request->get('queue_id'), $request->get('user_id')); 

            if($status)
            {
                return $this->successResponse([
                    'success' => 'Member Removed from Queue Successfully'
                ], 'Member Removed from Queue Successfully');
            }
        }
        
        return $this->setStatusCode(404)->failureResponse([
            'reason' => 'Invalid Inputs'
        ], 'Something went wrong !');
    }

    /**
     * Process Member
     *
     * @param Request $request
     * @return string
     */
    public function processMember(Request $request)
    {
        if($request->has('queue_id') && $request->has('user_id'))
        {
            $status = $this->repository->processQueueMember($request->get('queue_id'), $request->get('user_id')); 

            if($status)
            {
                return $this->successResponse([
                    'success' => 'Member Processed Successfully'
                ], 'Member Processed Successfully');
            }
        }
        
        return $this->setStatusCode(404)->failureResponse([
            'reason' => 'Invalid Inputs or No Member found in Queue'
        ], 'Something went wrong !');
    }

    /**
     * Get My Queue.
     *
     * @param Request $request
     * @return string
     */
    public function getMyQueue(Request $request)
    {
        $user = access()->user();

        if(isset($user->id) && $request->has('enterprise_id'))
        {
            $myQueue = QueueMember::with('queue', 'user')->where([
                'user_id'   => $user->id,
                'store_id'  => $request->get('enterprise_id')
            ])
            ->where('processed_at', null)
            ->first();

            if(isset($myQueue) && isset($myQueue->id))
            {
                $responseData = $this->queueTransformer->transformMyQueue($myQueue);
                return $this->successResponse($responseData);
            }
        }


        return $this->failureResponse([
            'reason' => 'No Queue found',
        ], 'No Queue found');
    }

    /**
     * Create
     *
     * @param Request $request
     * @return string
     */
    public function createByStore(Request $request)
    {
        if($request->has('enterprise_id'))
        {
            $status = $this->repository->createByStore($request->all());

            if($status)
            {
                $queueData    = $this->repository->getQueueWithMembers($request->get('enterprise_id'));
                $responseData = $this->queueTransformer->transform($queueData);
            }

            return $this->successResponse($responseData, 'Queue is Created Successfully');
        }

        return $this->setStatusCode(400)->failureResponse([
            'reason' => 'Invalid Inputs or Member has already Joined Queue'
            ], 'Something went wrong !');
    }
}