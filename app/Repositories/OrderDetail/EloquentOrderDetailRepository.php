<?php namespace App\Repositories\OrderDetail;

/**
 * Class EloquentOrderDetailRepository
 *
 * @author Anuj Jaha ( er.anujjaha@gmail.com)
 */

use App\Models\OrderDetail\OrderDetail;
use App\Repositories\DbRepository;
use App\Exceptions\GeneralException;

class EloquentOrderDetailRepository extends DbRepository
{
    /**
     * OrderDetail Model
     *
     * @var Object
     */
    public $model;

    /**
     * OrderDetail Title
     *
     * @var string
     */
    public $moduleTitle = 'OrderDetail';

    /**
     * Table Headers
     *
     * @var array
     */
    public $tableHeaders = [
        'id'        => 'Id',
'order_id'        => 'Order_id',
'item_id'        => 'Item_id',
'category_id'        => 'Category_id',
'title'        => 'Title',
'qty'        => 'Qty',
'price_with_tax'        => 'Price_with_tax',
'price_without_tax'        => 'Price_without_tax',
'notes'        => 'Notes',
'image'        => 'Image',
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
		'order_id' =>   [
                'data'          => 'order_id',
                'name'          => 'order_id',
                'searchable'    => true,
                'sortable'      => true
            ],
		'item_id' =>   [
                'data'          => 'item_id',
                'name'          => 'item_id',
                'searchable'    => true,
                'sortable'      => true
            ],
		'category_id' =>   [
                'data'          => 'category_id',
                'name'          => 'category_id',
                'searchable'    => true,
                'sortable'      => true
            ],
		'title' =>   [
                'data'          => 'title',
                'name'          => 'title',
                'searchable'    => true,
                'sortable'      => true
            ],
		'qty' =>   [
                'data'          => 'qty',
                'name'          => 'qty',
                'searchable'    => true,
                'sortable'      => true
            ],
		'price_with_tax' =>   [
                'data'          => 'price_with_tax',
                'name'          => 'price_with_tax',
                'searchable'    => true,
                'sortable'      => true
            ],
		'price_without_tax' =>   [
                'data'          => 'price_without_tax',
                'name'          => 'price_without_tax',
                'searchable'    => true,
                'sortable'      => true
            ],
		'notes' =>   [
                'data'          => 'notes',
                'name'          => 'notes',
                'searchable'    => true,
                'sortable'      => true
            ],
		'image' =>   [
                'data'          => 'image',
                'name'          => 'image',
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
        'listRoute'     => 'orderdetail.index',
        'createRoute'   => 'orderdetail.create',
        'storeRoute'    => 'orderdetail.store',
        'editRoute'     => 'orderdetail.edit',
        'updateRoute'   => 'orderdetail.update',
        'deleteRoute'   => 'orderdetail.destroy',
        'dataRoute'     => 'orderdetail.get-list-data'
    ];

    /**
     * Module Views
     *
     * @var array
     */
    public $moduleViews = [
        'listView'      => 'orderdetail.index',
        'createView'    => 'orderdetail.create',
        'editView'      => 'orderdetail.edit',
        'deleteView'    => 'orderdetail.destroy',
    ];

    /**
     * Construct
     *
     */
    public function __construct()
    {
        $this->model = new OrderDetail;
    }

    /**
     * Create OrderDetail
     *
     * @param array $input
     * @return mixed
     */
    public function create($input)
    {
        $input = $this->prepareInputData($input, true);
        $model = $this->model->create($input);

        if($model)
        {
            return $model;
        }

        return false;
    }

    /**
     * Update OrderDetail
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
     * Destroy OrderDetail
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
}