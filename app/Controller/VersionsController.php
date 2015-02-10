<?php
App::uses('AppController', 'Controller');
/**
 * Versions Controller
 *
 * @property Version $Version
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class VersionsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Session');

//    public function beforeFilter() {
//        parent::beforeFilter();
//        if($this->Auth->user('role') != 'admin'){
//            $this->Session->setFlash('No está autorizado a consultar esa página.');
//            return $this->redirect(array('controller' => 'applications', 'action' => 'repo'));
//        }
//    }


/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Version->recursive = 0;
		$this->set('versions', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Version->exists($id)) {
			throw new NotFoundException(__('Invalid version'));
		}
		$options = array('conditions' => array('Version.' . $this->Version->primaryKey => $id));
		$this->set('version', $this->Version->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Version->create();
			if ($this->Version->save($this->request->data)) {
				$this->Session->setFlash(__('The version has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The version could not be saved. Please, try again.'));
			}
		}
		$applications = $this->Version->Application->find('list');
		$this->set(compact('applications'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Version->exists($id)) {
			throw new NotFoundException(__('Invalid version'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Version->save($this->request->data)) {
				$this->Session->setFlash(__('The version has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The version could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Version.' . $this->Version->primaryKey => $id));
			$this->request->data = $this->Version->find('first', $options);
		}
		$applications = $this->Version->Application->find('list');
		$this->set(compact('applications'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Version->id = $id;
		if (!$this->Version->exists()) {
			throw new NotFoundException(__('Invalid version'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Version->delete()) {
			$this->Session->setFlash(__('The version has been deleted.'));
		} else {
			$this->Session->setFlash(__('The version could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
