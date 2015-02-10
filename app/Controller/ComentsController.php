<?php
App::uses('AppController', 'Controller');
/**
 * Coments Controller
 *
 */
class ComentsController extends AppController {

/**
 * Scaffold
 *
 * @var mixed
 */
	public $scaffold;

//    public function beforeFilter() {
//        parent::beforeFilter();
//        if($this->Auth->user('role') != 'admin'){
//            $this->Session->setFlash('No está autorizado a consultar esa página.');
//            return $this->redirect(array('controller' => 'applications', 'action' => 'repo'));
//        }
//    }

}
