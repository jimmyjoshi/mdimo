<?php namespace App\Repositories\Order;

/**
 * Class EloquentOrderRepository
 *
 * @author Anuj Jaha ( er.anujjaha@gmail.com)
 */

use App\Models\Order\Order;
use App\Repositories\DbRepository;
use App\Exceptions\GeneralException;
use App\Models\OrderDetail\OrderDetail;
use App\Models\Item\Item;

class EloquentOrderRepository extends DbRepository
{
    /**
     * Order Model
     *
     * @var Object
     */
    public $model;

    /**
     * Order Title
     *
     * @var string
     */
    public $moduleTitle = 'Order';

    /**
     * Table Headers
     *
     * @var array
     */
    public $tableHeaders = [
        'id'        => 'Id',
'user_id'        => 'User_id',
'store_id'        => 'Store_id',
'queue_id'        => 'Queue_id',
'processed_by'        => 'Processed_by',
'title'        => 'Title',
'notes'        => 'Notes',
'status'        => 'Status',
'processed_at'        => 'Processed_at',
'created_at'        => 'Created_at',
'updated_at'        => 'Updated_at',
"actions"         => "Actions"
    ];

    /**
     * Table Columns
     *
     * @var array
     */
    public $tableColumns = [
        'id' =>   [
                'data'          => 'id',
                'name'          => 'id',
                'searchable'    => true,
                'sortable'      => true
            ],
		'user_id' =>   [
                'data'          => 'user_id',
                'name'          => 'user_id',
                'searchable'    => true,
                'sortable'      => true
            ],
		'store_id' =>   [
                'data'          => 'store_id',
                'name'          => 'store_id',
                'searchable'    => true,
                'sortable'      => true
            ],
		'queue_id' =>   [
                'data'          => 'queue_id',
                'name'          => 'queue_id',
                'searchable'    => true,
                'sortable'      => true
            ],
		'processed_by' =>   [
                'data'          => 'processed_by',
                'name'          => 'processed_by',
                'searchable'    => true,
                'sortable'      => true
            ],
		'title' =>   [
                'data'          => 'title',
                'name'          => 'title',
                'searchable'    => true,
                'sortable'      => true
            ],
		'notes' =>   [
                'data'          => 'notes',
                'name'          => 'notes',
                'searchable'    => true,
                'sortable'      => true
            ],
		'status' =>   [
                'data'          => 'status',
                'name'          => 'status',
                'searchable'    => true,
                'sortable'      => true
            ],
		'processed_at' =>   [
                'data'          => 'processed_at',
                'name'          => 'processed_at',
                'searchable'    => true,
                'sortable'      => true
            ],
		'created_at' =>   [
                'data'          => 'created_at',
                'name'          => 'created_at',
                'searchable'    => true,
                'sortable'      => true
            ],
		'updated_at' =>   [
                'data'          => 'updated_at',
                'name'          => 'updated_at',
                'searchable'    => true,
                'sortable'      => true
            ],
		'actions' => [
            'data'          => 'actions',
            'name'          => 'actions',
            'searchable'    => false,
            'sortable'      => false
        ]
    ];

    /**
     * Is Admin
     *
     * @var boolean
     */
    protected $isAdmin = false;

    /**
     * Admin Route Prefix
     *
     * @var string
     */
    public $adminRoutePrefix = 'admin';

    /**
     * Client Route Prefix
     *
     * @var string
     */
    public $clientRoutePrefix = 'frontend';

    /**
     * Admin View Prefix
     *
     * @var string
     */
    public $adminViewPrefix = 'backend';

    /**
     * Client View Prefix
     *
     * @var string
     */
    public $clientViewPrefix = 'frontend';

    /**
     * Module Routes
     *
     * @var array
     */
    public $moduleRoutes = [
        'listRoute'     => 'order.index',
        'createRoute'   => 'order.create',
        'storeRoute'    => 'order.store',
        'editRoute'     => 'order.edit',
        'updateRoute'   => 'order.update',
        'deleteRoute'   => 'order.destroy',
        'dataRoute'     => 'order.get-list-data'
    ];

    /**
     * Module Views
     *
     * @var array
     */
    public $moduleViews = [
        'listView'      => 'order.index',
        'createView'    => 'order.create',
        'editView'      => 'order.edit',
        'deleteView'    => 'order.destroy',
    ];

    /**
     * Construct
     *
     */
    public function __construct()
    {
        $this->model = new Order;
    }

    /**
     * Create Order
     *
     * @param array $input
     * @return mixed
     */
    public function create($input)
    {
        $userId     = $input['user_id'];
        $categoryId = isset($input['category_id']) ? $input['category_id']: null;
        $queueId    = isset($input['queue_id']) && !empty($input['queue_id']) ? $input['queue_id'] : false;
        $storeId    = $input['enterprise_id'];
        $orderId    = isset($input['order_id']) ? $input['order_id'] : false;
        $items      = $input['items'];

        if($orderId)
        {
            $order = $this->model->where('id', $orderId)->first();

            if(!isset($order->id))
            {
                return false;
            }
        }

        if(is_array($items) && count($items))
        {
            if($queueId)
            {
                $order = $this->getOrderByQueueId($userId, $storeId, $queueId);

                if(isset($order) && isset($order->id))
                {
                    $status = $this->validateAddItem($order, $input);

                    if($status)
                    {
                        foreach($items as $myItem)
                        {   
                            $this->addOrderItems($order, [
                                'item_id' => $myItem['item_id'],
                                'qty'     => $myItem['qty']
                            ]);
                        }
                    }
                    return $order;
                }
                else
                {
                    $orderData = [
                        'user_id'   => $userId,
                        'store_id'  => $storeId,
                        'queue_id'  => $queueId,
                        'category_id' => $categoryId,
                        'title'     => 'New Order at ' . date('Y-m-d'),
                        'image'     => 'default.png'
                    ];

                    $order = $this->model->create($orderData);

                    $order->qr_code_image = $order->id .'.png';
                    $order->save();

                    \QRCode::text($order->id)
                        ->setOutfile(public_path() . '/order-images/'. $order->id .'.png')
                        ->png();

                    if(isset($order) && $order->id)
                    {
                        foreach($items as $myItem)
                        {   
                            $this->addOrderItems($order, [
                                'item_id' => $myItem['item_id'],
                                'qty'     => $myItem['qty']
                            ]);
                        }
                        return $order;
                    }
                }
            }
            else if(isset($order) && $orderId)
            {
                $this->flushOrderItems($orderId);

                foreach($items as $myItem)
                {   
                    $this->addOrderItems($order, [
                        'item_id' => $myItem['item_id'],
                        'qty'     => $myItem['qty']
                    ]);
                }

                return $order;
            }
            else
            {
                $order = $this->model->create([
                    'user_id'   => access()->user()->id,
                    'store_id'  => $storeId,
                    'title'     => 'Normal Order Created',
                    'image'     => 'default.png'
                ]);

                $order->qr_code_image = $order->id .'.png';
                $order->save();

                \QRCode::text($order->id)
                    ->setOutfile(public_path() . '/order-images/'. $order->id .'.png')
                    ->png();

                foreach($items as $myItem)
                {   
                    $this->addOrderItems($order, [
                        'item_id' => $myItem['item_id'],
                        'qty'     => $myItem['qty']
                    ]);
                }

                return $order;
            }
        }


        return false;
    }

    /**
     * Flush Order Items
     *
     * @param int $orderId
     * @return bool|int|mixed
     */
    public function flushOrderItems($orderId = null)
    {
        if($orderId)
        {
            return OrderDetail::where('order_id', $orderId)->delete();
        }

        return true;
    }

    /**
     * Update Order
     *
     * @param int $id
     * @param array $input
     * @return bool|int|mixed
     */
    public function update($id, $input)
    {
        $model = $this->model->find($id);

        if($model)
        {
            $input = $this->prepareInputData($input);

            return $model->update($input);
        }

        return false;
    }

    /**
     * Destroy Order
     *
     * @param int $id
     * @return mixed
     * @throws GeneralException
     */
    public function destroy($id)
    {
        $model = $this->model->find($id);

        if($model)
        {
            return $model->delete();
        }

        return  false;
    }

    /**
     * Get All
     *
     * @param string $orderBy
     * @param string $sort
     * @return mixed
     */
    public function getAll($orderBy = 'id', $sort = 'asc')
    {
        return $this->model->orderBy($orderBy, $sort)->get();
    }

    /**
     * Get by Id
     *
     * @param int $id
     * @return mixed
     */
    public function getById($id = null)
    {
        if($id)
        {
            return $this->model->find($id);
        }

        return false;
    }

    /**
     * Get Table Fields
     *
     * @return array
     */
    public function getTableFields()
    {
        return [
            $this->model->getTable().'.*'
        ];
    }

    /**
     * @return mixed
     */
    public function getForDataTable()
    {
        return $this->model->select($this->getTableFields())->get();
    }

    /**
     * Set Admin
     *
     * @param boolean $isAdmin [description]
     */
    public function setAdmin($isAdmin = false)
    {
        $this->isAdmin = $isAdmin;

        return $this;
    }

    /**
     * Prepare Input Data
     *
     * @param array $input
     * @param bool $isCreate
     * @return array
     */
    public function prepareInputData($input = array(), $isCreate = false)
    {
        if($isCreate)
        {
            $input = array_merge($input, ['user_id' => access()->user()->id]);
        }

        return $input;
    }

    /**
     * Get Table Headers
     *
     * @return string
     */
    public function getTableHeaders()
    {
        if($this->isAdmin)
        {
            return json_encode($this->setTableStructure($this->tableHeaders));
        }

        $clientHeaders = $this->tableHeaders;

        unset($clientHeaders['username']);

        return json_encode($this->setTableStructure($clientHeaders));
    }

    /**
     * Get Table Columns
     *
     * @return string
     */
    public function getTableColumns()
    {
        if($this->isAdmin)
        {
            return json_encode($this->setTableStructure($this->tableColumns));
        }

        $clientColumns = $this->tableColumns;

        unset($clientColumns['username']);

        return json_encode($this->setTableStructure($clientColumns));
    }

    public function getOrderByQueueId($userId = null, $storeId = null, $queueId = null)
    {
        if($queueId)
        {
            $order = $this->model->where([
                'user_id'   => $userId,
                'store_id'  => $storeId,
                'queue_id'  => $queueId
            ])->first();

            if(isset($order->id))
            {
                return $order;
            }
        }

        return false;
    }

    public function addOrderItems($order, $input = array())
    {
        if($order)
        {
            $item = Item::where('id', $input['item_id'])->first();
            
            if(isset($item) && isset($item->id))
            {
                $orderItems = [
                    'order_id'          => $order->id,
                    'item_id'           => $item->id,
                    'category_id'       => $item->food_category_id,
                    'title'             => $item->food_short_name,
                    'qty'               => $input['qty'],
                    'price_with_tax'    => $item->price_with_tax,
                    'price_without_tax' => $item->price_without_tax,
                    'image'             => $item->food_image
                ];

                return OrderDetail::create($orderItems);
            }
        }

        return false;
    }

    public function getOrderWithDetails($orderId = null)
    {
        if($orderId)
        {
            return $this->model->with('order_details', 'order_details.category')
                ->where('id', $orderId)
                ->first();
        }

        return false;
    }

    public function validateAddItem($order, $input)
    {
        if(isset($input['item_id']))
        {
            $order = OrderDetail::where([
                'order_id'  => $order->id,
                'item_id'   => $input['item_id']
            ])->first();

            if(isset($order) && isset($order->id))
            {
                if(isset($input['qty']) && $input['qty'] > 0)
                {
                    $order->qty = $input['qty'];
                    $order->save();
                    return false;
                }

                if(isset($input['qty']) && $input['qty'] == 0)
                {
                    $order->delete();
                    return false;
                }
            }
        }
        
        return true;
    }
}