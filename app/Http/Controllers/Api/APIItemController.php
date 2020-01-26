<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Transformers\ItemTransformer;
use App\Http\Controllers\Api\BaseApiController;
use App\Repositories\Item\EloquentItemRepository;

class APIItemController extends BaseApiController
{
    /**
     * Item Transformer
     *
     * @var Object
     */
    protected $itemTransformer;

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
    protected $primaryKey = 'item_id';

    /**
     * __construct
     *
     */
    public function __construct()
    {
        $this->repository                       = new EloquentItemRepository();
        $this->itemTransformer = new ItemTransformer();
    }

    /**
     * List of All Item
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
            $itemsOutput = $this->itemTransformer->transformCollection($items);

            return $this->successResponse($itemsOutput);
        }

        return $this->setStatusCode(400)->failureResponse([
            'message' => 'Unable to find Item!'
            ], 'No Item Found !');
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
            'user_id'   => $user->id,
            'food_image'     => 'default.png'
        ]);
        
        $uploadedFile = $request->file('image'); 

        if($uploadedFile)
        {
            $filename   = time().$uploadedFile->getClientOriginalName();
            $filePath   = public_path() . '/img/item/';
            
            if($uploadedFile->move($filePath, $filename))
            {
                $input['food_image'] = $filename;
            }
        }

        $model = $this->repository->create($input);

        if($model)
        {
            $responseData = $this->itemTransformer->transform($model);

            return $this->successResponse($responseData, 'Item is Created Successfully');
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
                $responseData = $this->itemTransformer->transform($itemData);

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
        if($request->has('item_id') && $request->get('item_id'))
        {
            $itemId = $request->get('item_id');
            $input  = $request->all();
            
            $uploadedFile = $request->file('image'); 

            if($uploadedFile)
            {
                $filename   = time().$uploadedFile->getClientOriginalName();
                $filePath   = public_path() . '/img/item/';
                
                if($uploadedFile->move($filePath, $filename))
                {
                    $input['image'] = $filename;
                }
            }

            $status = $this->repository->update($itemId, $input);

            if($status)
            {
                $itemData       = $this->repository->getById($itemId);
                $responseData   = $this->itemTransformer->transform($itemData);

                return $this->successResponse($responseData, 'Item is Edited Successfully');
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
        if($request->has('item_id') && $request->get('item_id'))
        {
            $itemId = $request->get('item_id');
            $status = $this->repository->destroy($itemId);

            if($status)
            {
                return $this->successResponse([
                    'success' => 'Item Deleted'
                ], 'Item is Deleted Successfully');
            }
        }

        return $this->setStatusCode(404)->failureResponse([
            'reason' => 'Invalid Inputs'
        ], 'Something went wrong !');
    }
}