<?php
App::uses('AppController', 'Controller');
/**
 * Noticies Controller
 *
 * @property Noticy $Noticy
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class NoticiesController extends AppController {

/**
 * Helpers
 *
 * @var array
 */
	public $helpers = array('Js');

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
		$this->Noticy->recursive = 0;
		$this->set('noticies', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Noticy->exists($id)) {
			throw new NotFoundException(__('Invalid noticy'));
		}
		$options = array('conditions' => array('Noticy.' . $this->Noticy->primaryKey => $id));
		$this->set('noticy', $this->Noticy->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Noticy->create();
			if ($this->Noticy->save($this->request->data)) {
				$this->Session->setFlash(__('The noticy has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The noticy could not be saved. Please, try again.'));
			}
		}
		$users = $this->Noticy->User->find('list');
		$this->set(compact('users'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Noticy->exists($id)) {
			throw new NotFoundException(__('Invalid noticy'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Noticy->save($this->request->data)) {
				$this->Session->setFlash(__('The noticy has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The noticy could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Noticy.' . $this->Noticy->primaryKey => $id));
			$this->request->data = $this->Noticy->find('first', $options);
		}
		$users = $this->Noticy->User->find('list');
		$this->set(compact('users'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Noticy->id = $id;
		if (!$this->Noticy->exists()) {
			throw new NotFoundException(__('Invalid noticy'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Noticy->delete()) {
			$this->Session->setFlash(__('The noticy has been deleted.'));
		} else {
			$this->Session->setFlash(__('The noticy could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
