<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Tasks Controller
 *
 * @property \App\Model\Table\TasksTable $Tasks
 *
 * @method \App\Model\Entity\Task[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TasksController extends ApiController
{

    public function initialize()
    {

        parent::initialize(); // TODO: Change the autogenerated stub
        $this->Tasks->HawkFiles->setUser($this->Auth->user());
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $tasks = $this->Tasks->find('search', ['search' => $this->getRequest()->getQueryParams()])
            ->contain([
                'HawkFiles', 'Owners', 'Users'
            ])
            ->order(['Tasks.due' => 'ASC']);
        if (empty($this->getRequest()->getQueryParams())) {
            $tasks->where(['done' => 0]);
        }

        $this->set(compact('tasks'));
    }

    public function unread()
    {
        return $this->Tasks->find('unread');
    }

    /**
     * View method
     *
     * @param string|null $id Task id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $task = $this->Tasks->get($id, [
            'contain' => ['HawkFiles', 'Owners', 'Users']
        ]);

        $this->set('task', $task);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add($fileId)
    {
        $hawkFile = $this->Tasks->HawkFiles->find()->where(['id' => $fileId])->first()->id;
        if (empty($hawkFile)) {
            $this->Flash->error(__('Δεν βρέθηκε το αρχείο για τη δημιουργία εργασίας'));
            return $this->redirect(['controller' => 'HawkFiles','action' => 'index']);
        }
        $task = $this->Tasks->newEntity();
        if ($this->getRequest()->is('post')) {
            $task = $this->Tasks->patchEntity($task, $this->getRequest()->getData());
            if ($this->Tasks->save($task)) {
                $this->Flash->success(__('Η εργασία προσθέθηκε'));
                return $this->redirect(['controller' => 'HawkFiles', 'action' => 'index']);
            }
            $this->Flash->error(__('Δεν καταφέραμε να προσθέσουμε την εργασία'));
        }
        $users = $this->Tasks->Users
            ->find('list')
            ->matching('HawkUsers')->where(['HawkUsers.hawk_file_id' => $hawkFile]);
        $owner = $this->Auth->user()['id'];
        $this->set(compact('task', 'users', 'owner', 'hawkFile'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Task id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $task = $this->Tasks->get($id);
        if ($this->getRequest()->is(['post', 'patch', 'put'])) {
            $task = $this->Tasks->patchEntity($task, $this->getRequest()->getData());
            if (in_array('done', $task->getDirty()) && !$task->done) {
                $task->is_read = false;
            }
            if ($this->Tasks->save($task)) {
                $this->Flash->success(__('Η εργασία επεξεργάστηκε με επιτυχία'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Δεν καταφέραμε να αποθηκεύσουμε την εργασία'));
        }
        $users = $this->Tasks->Users
            ->find('list')
            ->matching('HawkUsers')->where(['HawkUsers.hawk_file_id' => $task->hawk_file_id]);
        $owner = $this->Auth->user()['id'];
        $this->set(compact('task', 'users', 'owner', 'hawkFile'));
    }

    public function read($id)
    {
        $task = $this->Tasks->get($id);
        $task->is_read = !$task->is_read;
        $this->Tasks->save($task);
        return $this->redirect(['action' => 'index']);
    }
    public function do($id)
    {
        $task = $this->Tasks->get($id);
        $task->done = !$task->done;
        $this->Tasks->save($task);
        return $this->redirect(['action' => 'index']);
    }
}
