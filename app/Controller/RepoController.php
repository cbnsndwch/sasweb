<?php
App::uses('AppController', 'Controller');

class RepoController extends AppController {

    public $helpers = array('Html', 'Form');
//    public $name = 'Apks';
/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator','RequestHandler');


	public function index() {
		$this->Apks->recursive = 0;
		$this->set('apks', $this->Paginator->paginate());
	}

}
