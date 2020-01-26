<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Transformers\StoreTransformer;
use App\Http\Controllers\Api\BaseApiController;
use App\Repositories\Store\EloquentStoreRepository;

class APIStoreController extends BaseApiController
{
    /**
     * Store Transformer
     *
     * @var Object
     */
    protected $storeTransformer;

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
    protected $primaryKey = 'store_id';

    /**
     * __construct
     *
     */
    public function __construct()
    {
        $this->repository       = new EloquentStoreRepository();
        $this->storeTransformer = new StoreTransformer();
    }

    /**
     * List of All Store
     *
     * @param Request $request
     * @return json
     */
    public function index(Request $request)
    {
        $paginate   = $request->get('paginate') ? $request->get('paginate') : false;
        $orderBy    = $request->get('orderBy') ? $request->get('orderBy') : 'id';
        $order      = $request->get('order') ? $request->get('order') : 'ASC';
        $items      = $paginate ? $this->repository->model->orderBy($orderBy, $order)->paginate($paginate)->items() : $this->repository->getAll($orderBy, $order);

        if(isset($items) && count($items))
        {
            $itemsOutput = $this->storeTransformer->transformCollection($items);

            return $this->successResponse($itemsOutput);
        }

        return $this->setStatusCode(400)->failureResponse([
            'message' => 'Unable to find Store!'
            ], 'No Store Found !');
    }

    /**
     * Create
     *
     * @param Request $request
     * @return string
     */
    public function create(Request $request)
    {
        $user   = access()->user();
        $model  = false;
        $input  = array_merge($request->all(), [
            'user_id'                       => $user->id,
            'enterprise_display_image'      => 'enterprise_default_display.png'
        ]);
        
        $uploadedFile = $request->file('image'); 

        if($uploadedFile)
        {
            $filename   = time().$uploadedFile->getClientOriginalName();
            $filePath   = public_path() . '/img/store/';
            
            if($uploadedFile->move($filePath, $filename))
            {
                $input['enterprise_display_image'] = $filename;
            }
        }

        if(isset($user->store) && isset($user->store->id))
        {
            $status = $this->repository->update($user->store->id, $input);
            $msg    = 'Store is Updated Successfully';

            if($status)
            {
                $model = $this->repository->model->where('id', $user->store->id)->first();
            }
        }
        else
        {
            $model = $this->repository->create($input);
            $msg   = 'Store is Created Successfully';
        }

        if($model)
        {
            $responseData = $this->storeTransformer->transform($model);

            return $this->successResponse($responseData, $msg);
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
                $responseData = $this->storeTransformer->transform($itemData);

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
                $responseData   = $this->storeTransformer->transform($itemData);

                return $this->successResponse($responseData, 'Store is Edited Successfully');
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
                    'success' => 'Store Deleted'
                ], 'Store is Deleted Successfully');
            }
        }

        return $this->setStatusCode(404)->failureResponse([
            'reason' => 'Invalid Inputs'
        ], 'Something went wrong !');
    }
}