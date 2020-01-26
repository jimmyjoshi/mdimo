<?php namespace App\Repositories\QueueMember;

/**
 * Class EloquentQueueMemberRepository
 *
 * @author Anuj Jaha ( er.anujjaha@gmail.com)
 */

use App\Models\QueueMember\QueueMember;
use App\Repositories\DbRepository;
use App\Exceptions\GeneralException;

class EloquentQueueMemberRepository extends DbRepository
{
    /**
     * QueueMember Model
     *
     * @var Object
     */
    public $model;

    /**
     * QueueMember Title
     *
     * @var string
     */
    public $moduleTitle = 'QueueMember';

    /**
     * Table Headers
     *
     * @var array
     */
    public $tableHeaders = [
        'id'        => 'Id',
'queue_id'        => 'Queue_id',
'store_id'        => 'Store_id',
'user_id'        => 'User_id',
'queue_number'        => 'Queue_number',
'member_count'        => 'Member_count',
'processed_number'        => 'Processed_number',
'processed_at'        => 'Processed_at',
'description'        => 'Description',
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
		'queue_id' =>   [
                'data'          => 'queue_id',
                'name'          => 'queue_id',
                'searchable'    => true,
                'sortable'      => true
            ],
		'store_id' =>   [
                'data'          => 'store_id',
                'name'          => 'store_id',
                'searchable'    => true,
                'sortable'      => true
            ],
		'user_id' =>   [
                'data'          => 'user_id',
                'name'          => 'user_id',
                'searchable'    => true,
                'sortable'      => true
            ],
		'queue_number' =>   [
                'data'          => 'queue_number',
                'name'          => 'queue_number',
                'searchable'    => true,
                'sortable'      => true
            ],
		'member_count' =>   [
                'data'          => 'member_count',
                'name'          => 'member_count',
                'searchable'    => true,
                'sortable'      => true
            ],
		'processed_number' =>   [
                'data'          => 'processed_number',
                'name'          => 'processed_number',
                'searchable'    => true,
                'sortable'      => true
            ],
		'processed_at' =>   [
                'data'          => 'processed_at',
                'name'          => 'processed_at',
                'searchable'    => true,
                'sortable'      => true
            ],
		'description' =>   [
                'data'          => 'description',
                'name'          => 'description',
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
        'listRoute'     => 'queuemember.index',
        'createRoute'   => 'queuemember.create',
        'storeRoute'    => 'queuemember.store',
        'editRoute'     => 'queuemember.edit',
        'updateRoute'   => 'queuemember.update',
        'deleteRoute'   => 'queuemember.destroy',
        'dataRoute'     => 'queuemember.get-list-data'
    ];

    /**
     * Module Views
     *
     * @var array
     */
    public $moduleViews = [
        'listView'      => 'queuemember.index',
        'createView'    => 'queuemember.create',
        'editView'      => 'queuemember.edit',
        'deleteView'    => 'queuemember.destroy',
    ];

    /**
     * Construct
     *
     */
    public function __construct()
    {
        $this->model = new QueueMember;
    }

    /**
     * Create QueueMember
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
     * Update QueueMember
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
     * Destroy QueueMember
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