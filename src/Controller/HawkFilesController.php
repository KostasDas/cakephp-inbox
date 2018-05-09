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
class HawkFilesController extends AppController
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
     * View method
     *
     * @param string|null $id Hawk File id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $hawkFile = $this->HawkFiles->get($id, [
            'contain' => []
        ]);

        $this->set('hawkFile', $hawkFile);
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

    /**
     * Delete method
     *
     * @param string|null $id Hawk File id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $hawkFile = $this->HawkFiles->get($id);
        if ($this->HawkFiles->delete($hawkFile)) {
            $this->Flash->success(__('The hawk file has been deleted.'));
        } else {
            $this->Flash->error(__('The hawk file could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
