<?php namespace App\Repositories\Queue;

/**
 * Class EloquentQueueRepository
 *
 * @author Anuj Jaha ( er.anujjaha@gmail.com)
 */

use App\Models\Queue\Queue;
use App\Repositories\DbRepository;
use App\Exceptions\GeneralException;
use App\Models\Store\Store;
use App\Models\QueueMember\QueueMember;
use Carbon\Carbon;

class EloquentQueueRepository extends DbRepository
{
    /**
     * Queue Model
     *
     * @var Object
     */
    public $model;

    /**
     * Queue Title
     *
     * @var string
     */
    public $moduleTitle = 'Queue';

    /**
     * Table Headers
     *
     * @var array
     */
    public $tableHeaders = [
        'id'        => 'Id',
'user_id'        => 'User_id',
'store_id'        => 'Store_id',
'title'        => 'Title',
'description'        => 'Description',
'qdate'        => 'Qdate',
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
		'store_id' =>   [
                'data'          => 'store_id',
                'name'          => 'store_id',
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
		'qdate' =>   [
                'data'          => 'qdate',
                'name'          => 'qdate',
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
        'listRoute'     => 'queue.index',
        'createRoute'   => 'queue.create',
        'storeRoute'    => 'queue.store',
        'editRoute'     => 'queue.edit',
        'updateRoute'   => 'queue.update',
        'deleteRoute'   => 'queue.destroy',
        'dataRoute'     => 'queue.get-list-data'
    ];

    /**
     * Module Views
     *
     * @var array
     */
    public $moduleViews = [
        'listView'      => 'queue.index',
        'createView'    => 'queue.create',
        'editView'      => 'queue.edit',
        'deleteView'    => 'queue.destroy',
    ];

    /**
     * Construct
     *
     */
    public function __construct()
    {
        $this->model = new Queue;
    }

    /**
     * Create Queue
     *
     * @param array $input
     * @return mixed
     */
    public function create($input)
    {
        $date  = date("Y-m-d", strtotime($input['today']));
        $queue = $this->getTodayQueue($input['store_id'], $date);
        $store = Store::where('id', $input['store_id'])->first();

        if(isset($queue) && isset($queue->id))
        {
            $status = $this->validateMember($queue, $input['user_id']);

            if($status)
            {
                $this->addQueueMember($queue, $input);
                return $queue;
            }

            return false;
        }
        else
        {   
            if(isset($store) && isset($store->id))
            {
                $queue = $this->model->create([
                    'user_id'       => access()->user()->id,
                    'store_id'      => $input['store_id'],
                    'title'         => $store->title . ' Queue',
                    'qdate'         => $date
                ]);

                $this->addQueueMember($queue, $input);

                return $queue;
            }
        }
        
        return false;
    }

    /**
     * Validate Member
     *
     * @param object $queue
     * @param int $userId
     * @return bool|int|mixed
     */
    public function validateMember($queue, $userId = null)
    {
        $count = QueueMember::where([
            'queue_id' => $queue->id,
            'user_id'  => $userId 
        ])
        ->where('processed_at', null)
        ->count();

        if($count > 0 )
        {
            return false;
        }

        return true;
    }

    /**
     * Add Queue Member
     *
     * @param object $queue
     * @param array $input
     * @return bool|int|mixed
     */
    public function addQueueMember($queue = null, $input)
    {
        if($queue)
        {
            $queueNumber = access()->getQueueNumber($input['store_id'], $queue->qdate);
            $queueMember = [
                'queue_id'      => $queue->id,
                'store_id'      => $input['store_id'],
                'user_id'       => $input['user_id'],
                'queue_number'  => $queueNumber,
                'member_count'  => $input['member_count'],
                'description'   => 'Join Queue at ' . $queueNumber
            ];

            return QueueMember::create($queueMember);
        }
    }

    /**
     * Update Queue
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
     * Destroy Queue
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

    /**
     * Get Today Queue
     *
     * @param int storeId
     * @return date date
     * @return object
     */
    public function getTodayQueue($storeId = null, $date = null)
    {
        if($storeId && $date)
        {
            return $this->model->with('members')->where([
                'store_id'  => $storeId,
                'qdate'     => date('Y-m-d', strtotime($date))
            ])->first();
        }

        return [];
    }

    /**
     * Get Queue with Members
     *
     * @param int storeId
     * @return date date
     * @return object
     */
    public function getQueueWithMembers($storeId = null, $date = null)
    {
        if($storeId && $date)
        {
            return $this->model->with(['members', 'members.user'])->where([
                'store_id'  => $storeId,
                'qdate'     => date('Y-m-d', strtotime($date))
            ])->first();
        }

        return [];
    }    

    /**
     * Remove Queue Member
     *
     * @param int queueId
     * @param int storeId
     * @return bool
     */
    public function removeQueueMember($queueId = null, $userId = null)
    {
        if($queueId && $userId)
        {
            $queueMember = QueueMember::where([
                'queue_id'  => $queueId,
                'user_id'   => $userId
            ])->first();

            if(isset($queueMember) && isset($queueMember->id))
            {
                if(isset($queueMember->processed_at))   
                {
                    $queueMember->delete();
                    return true;
                }

                $this->shuffleQueue($queueMember);
                $queueMember->delete();
            }
        }

        return true;
    }

    /**
     * Shuffle Queue
     *
     * @param object queueMember
     * @return bool
     */
    public function shuffleQueue($queueMember)
    {
        $queueMembers = QueueMember::where([
            'queue_id'  => $queueMember->queue_id,
        ])
        ->where('id', '>', $queueMember->id)
        ->get();   

        if(isset($queueMembers))
        {
            foreach($queueMembers as $qMember)
            {
                if($qMember->processed_at == null)
                {
                    $qMember->queue_number = $qMember->queue_number - 1;
                    $qMember->save();
                }
            }
        }

        return true;
    }

    /**
     * Process Queue Member
     *
     * @param int queueId
     * @param int storeId
     * @return bool
     */
    public function processQueueMember($queueId = null, $userId = null)
    {
        if($queueId && $userId)
        {
            $queueMember = QueueMember::where([
                'queue_id'  => $queueId,
                'user_id'   => $userId
            ])->first();

            if(isset($queueMember) && isset($queueMember->id))
            {
                if(!isset($queueMember->processed_at))   
                {
                    $status = $this->processMember($queueMember);

                    if($status)
                    {
                        $this->shuffleQueue($queueMember);
                    }
                }
            }
        }

        return true;       
    }

    /**
     * Process Member
     *
     * @param int queueId
     * @param int storeId
     * @return bool
     */
    public function processMember($queueMember)
    {
        $queueMember->processed_at      = date('Y-m-d H:i:s');
        $queueMember->processed_number  = $queueMember->queue_number;
        $queueMember->queue_number      = 0;
        $queueMember->description       = 'Processed at ' . date('Y-m-d H:i:s');
        return $queueMember->save();
    }
}