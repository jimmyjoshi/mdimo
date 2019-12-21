<?php namespace App\Repositories\Store;

/**
 * Class EloquentStoreRepository
 *
 * @author Anuj Jaha ( er.anujjaha@gmail.com)
 */

use App\Models\Store\Store;
use App\Repositories\DbRepository;
use App\Exceptions\GeneralException;

class EloquentStoreRepository extends DbRepository
{
    /**
     * Store Model
     *
     * @var Object
     */
    public $model;

    /**
     * Store Title
     *
     * @var string
     */
    public $moduleTitle = 'Store';

    /**
     * Table Headers
     *
     * @var array
     */
    public $tableHeaders = [
        'id'        => 'Id',
'user_id'        => 'User_id',
'title'        => 'Title',
'description'        => 'Description',
'address'        => 'Address',
'city'        => 'City',
'state'        => 'State',
'zip'        => 'Zip',
'image'        => 'Image',
'latitude'        => 'Latitude',
'longitude'        => 'Longitude',
'is_active'        => 'Is_active',
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
		'title' =>   [
                'data'          => 'title',
                'name'          => 'title',
                'searchable'    => true,
                'sortable'      => true
            ],
		'description' =>   [
                'data'          => 'description',
                'name'          => 'description',
                'searchable'    => true,
                'sortable'      => true
            ],
		'address' =>   [
                'data'          => 'address',
                'name'          => 'address',
                'searchable'    => true,
                'sortable'      => true
            ],
		'city' =>   [
                'data'          => 'city',
                'name'          => 'city',
                'searchable'    => true,
                'sortable'      => true
            ],
		'state' =>   [
                'data'          => 'state',
                'name'          => 'state',
                'searchable'    => true,
                'sortable'      => true
            ],
		'zip' =>   [
                'data'          => 'zip',
                'name'          => 'zip',
                'searchable'    => true,
                'sortable'      => true
            ],
		'image' =>   [
                'data'          => 'image',
                'name'          => 'image',
                'searchable'    => true,
                'sortable'      => true
            ],
		'latitude' =>   [
                'data'          => 'latitude',
                'name'          => 'latitude',
                'searchable'    => true,
                'sortable'      => true
            ],
		'longitude' =>   [
                'data'          => 'longitude',
                'name'          => 'longitude',
                'searchable'    => true,
                'sortable'      => true
            ],
		'is_active' =>   [
                'data'          => 'is_active',
                'name'          => 'is_active',
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
        'listRoute'     => 'store.index',
        'createRoute'   => 'store.create',
        'storeRoute'    => 'store.store',
        'editRoute'     => 'store.edit',
        'updateRoute'   => 'store.update',
        'deleteRoute'   => 'store.destroy',
        'dataRoute'     => 'store.get-list-data'
    ];

    /**
     * Module Views
     *
     * @var array
     */
    public $moduleViews = [
        'listView'      => 'store.index',
        'createView'    => 'store.create',
        'editView'      => 'store.edit',
        'deleteView'    => 'store.destroy',
    ];

    /**
     * Construct
     *
     */
    public function __construct()
    {
        $this->model = new Store;
    }

    /**
     * Create Store
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
     * Update Store
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
     * Destroy Store
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