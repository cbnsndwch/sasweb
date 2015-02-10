<?php
App::uses('AppController', 'Controller');
/**
 * Networks Controller
 *
 * @property Network $Network
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class NetworksController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Session');

 public function beforeFilter(){
        parent::beforeFilter();

        $this->Paginator->settings=array(
            'limit'=>15,
           
        );
    }
/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Network->recursive = 0;
		$this->set('networks', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Network->exists($id)) {
			throw new NotFoundException(__('Invalid network'));
		}
		$options = array('conditions' => array('Network.' . $this->Network->primaryKey => $id));
		$this->set('network', $this->Network->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Network->create();
			if ($this->Network->save($this->request->data)) {
				$this->Session->setFlash(__('The network has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The network could not be saved. Please, try again.'));
			}
		}
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Network->exists($id)) {
			throw new NotFoundException(__('Invalid network'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Network->save($this->request->data)) {
				$this->Session->setFlash(__('The network has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The network could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Network.' . $this->Network->primaryKey => $id));
			$this->request->data = $this->Network->find('first', $options);
		}
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Network->id = $id;
		if (!$this->Network->exists()) {
			throw new NotFoundException(__('Invalid network'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Network->delete()) {
			$this->Session->setFlash(__('The network has been deleted.'));
		} else {
			$this->Session->setFlash(__('The network could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
