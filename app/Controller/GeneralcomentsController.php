<?php
App::uses('AppController', 'Controller');
/**
 * Generalcoments Controller
 *
 * @property Generalcoment $Generalcoment
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class GeneralcomentsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Session');

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Generalcoment->recursive = 0;
		$this->set('generalcoments', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Generalcoment->exists($id)) {
			throw new NotFoundException(__('Invalid generalcoment'));
		}
		$options = array('conditions' => array('Generalcoment.' . $this->Generalcoment->primaryKey => $id));
		$this->set('generalcoment', $this->Generalcoment->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Generalcoment->create();
			if ($this->Generalcoment->save($this->request->data)) {
				$this->Session->setFlash(__('The generalcoment has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The generalcoment could not be saved. Please, try again.'));
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
		if (!$this->Generalcoment->exists($id)) {
			throw new NotFoundException(__('Invalid generalcoment'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Generalcoment->save($this->request->data)) {
				$this->Session->setFlash(__('The generalcoment has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The generalcoment could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Generalcoment.' . $this->Generalcoment->primaryKey => $id));
			$this->request->data = $this->Generalcoment->find('first', $options);
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
		$this->Generalcoment->id = $id;
		if (!$this->Generalcoment->exists()) {
			throw new NotFoundException(__('Invalid generalcoment'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Generalcoment->delete()) {
			$this->Session->setFlash(__('The generalcoment has been deleted.'));
		} else {
			$this->Session->setFlash(__('The generalcoment could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
