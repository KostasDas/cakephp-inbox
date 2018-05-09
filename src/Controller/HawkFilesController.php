<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * HawkFiles Controller
 *
 * @property \App\Model\Table\HawkFilesTable $HawkFiles
 *
 * @method \App\Model\Entity\HawkFile[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class HawkFilesController extends ApiController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $hawkFiles = $this->paginate($this->HawkFiles);

        $this->set('authUser', $this->Auth->user());
        $this->set(compact('hawkFiles'));
    }
    /**
     * @param null $file_id
     *
     **/
    public function view($file_id = null)
    {
        $hawkFile = $this->HawkFiles->get($file_id);
        return $this->getResponse()->withFile($hawkFile->location);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $hawkFile = $this->HawkFiles->newEntity();
        if ($this->request->is('post')) {
            $hawkFile = $this->HawkFiles->patchEntity($hawkFile, $this->request->getData());
            if ($this->HawkFiles->save($hawkFile)) {
                $this->Flash->success(__('The hawk file has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The hawk file could not be saved. Please, try again.'));
        }
        $this->set(compact('hawkFile'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Hawk File id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $hawkFile = $this->HawkFiles->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $hawkFile = $this->HawkFiles->patchEntity($hawkFile, $this->request->getData());
            if ($this->HawkFiles->save($hawkFile)) {
                $this->Flash->success(__('The hawk file has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The hawk file could not be saved. Please, try again.'));
        }
        $this->set(compact('hawkFile'));
    }

    private function loadOptions()
    {
        $types = $this->HawkFiles->find('list', [
            'keyField' => 'type',
            'valueField' => 'type'
        ])->distinct();
        $senders =$this->HawkFiles->find('list', [
            'keyField' => 'sender',
            'valueField' => 'sender'
        ])->distinct();
        $offices =$this->HawkFiles->find('list', [
            'keyField' => 'office',
            'valueField' => 'office'
        ])->distinct();

        $this->set(compact('types', 'senders', 'offices'));

    }

    public function inbox ()
    {
        $files = $this->HawkFiles->find('search', ['search' => $this->request->getQueryParams()]);

        $this->set(compact('files'));
        $this->set('authUser', $this->Auth->user());
    }

    public function types()
    {
        $types = $this->HawkFiles->find()
            ->select(['type'])
            ->order(['type' => 'ASC'])
            ->distinct()
            ->toArray();

        $this->set('types', $types);
    }
    public function senders()
    {
        $senders = $this->HawkFiles->find()
            ->select(['sender'])
            ->order(['sender' => 'ASC'])
            ->distinct()
            ->toArray();

        $this->set('senders', $senders);
    }
    public function offices()
    {
        $offices = $this->HawkFiles->find()
            ->select(['office'])
            ->order(['office' => 'ASC'])
            ->distinct()
            ->toArray();

        $this->set('offices', $offices);
    }

    public function download($file_id)
    {
        $hawkFile = $this->HawkFiles->get($file_id);
        return $this->getResponse()->withFile($hawkFile->location, [
            'download' => true
        ]);
    }
}
