<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Transformers\OrderTransformer;
use App\Http\Controllers\Api\BaseApiController;
use App\Repositories\Order\EloquentOrderRepository;

class APIOrderController extends BaseApiController
{
    /**
     * Order Transformer
     *
     * @var Object
     */
    protected $orderTransformer;

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
    protected $primaryKey = 'order_id';

    /**
     * __construct
     *
     */
    public function __construct()
    {
        $this->repository                       = new EloquentOrderRepository();
        $this->orderTransformer = new OrderTransformer();
    }

    /**
     * List of All Order
     *
     * @param Request $request
     * @return json
     */
    public function index(Request $request)
    {
        if($request->has('order_id') && $request->get('order_id'))
        {
            $order = $this->repository->getOrderWithDetails($request->get('order_id'));

            if($order)
            {
                $response = $this->orderTransformer->transform($order);

                return $this->successResponse($response, 'Order Details');
            }
        }

        return $this->setStatusCode(400)->failureResponse([
            'message' => 'Unable to find Order!'
            ], 'No Order Found !');
    }

    /**
     * Create
     *
     * @param Request $request
     * @return string
     */
    public function create(Request $request)
    {
        $model = $this->repository->create($request->all());

        if($model)
        {
            $order      = $this->repository->getOrderWithDetails($model->id);
            $response   = $this->orderTransformer->transform($order);

            

            return $this->successResponse($response, 'Order is Created Successfully');
        }

        return $this->setStatusCode(400)->failureResponse([
            'reason' => 'Invalid Inputs'
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
                $responseData = $this->orderTransformer->transform($itemData);

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
                $responseData   = $this->orderTransformer->transform($itemData);

                return $this->successResponse($responseData, 'Order is Edited Successfully');
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
                    'success' => 'Order Deleted'
                ], 'Order is Deleted Successfully');
            }
        }

        return $this->setStatusCode(404)->failureResponse([
            'reason' => 'Invalid Inputs'
        ], 'Something went wrong !');
    }
}