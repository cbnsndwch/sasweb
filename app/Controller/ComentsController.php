<?php
App::uses('AppController', 'Controller');
/**
 * Coments Controller
 *
 * @property Coment $Coment
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class ComentsController extends AppController {

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
		$this->Coment->recursive = 0;
		$this->set('coments', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Coment->exists($id)) {
			throw new NotFoundException(__('Invalid coment'));
		}
		$options = array('conditions' => array('Coment.' . $this->Coment->primaryKey => $id));
		$this->set('coment', $this->Coment->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Coment->create();
			if ($this->Coment->save($this->request->data)) {
				$this->Session->setFlash(__('The coment has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The coment could not be saved. Please, try again.'));
			}
		}
		$users = $this->Coment->User->find('list');
		$applications = $this->Coment->Application->find('list');
		$this->set(compact('users', 'applications'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Coment->exists($id)) {
			throw new NotFoundException(__('Invalid coment'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Coment->save($this->request->data)) {
				$this->Session->setFlash(__('The coment has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The coment could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Coment.' . $this->Coment->primaryKey => $id));
			$this->request->data = $this->Coment->find('first', $options);
		}
		$users = $this->Coment->User->find('list');
		$applications = $this->Coment->Application->find('list');
		$this->set(compact('users', 'applications'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Coment->id = $id;
		if (!$this->Coment->exists()) {
			throw new NotFoundException(__('Invalid coment'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Coment->delete()) {
			$this->Session->setFlash(__('The coment has been deleted.'));
		} else {
			$this->Session->setFlash(__('The coment could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
