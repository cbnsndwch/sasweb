<?php
App::uses('AppController', 'Controller');
App::uses('AjaxMultiUpload', 'Upload');
/**
 * Data Controller
 *
 * @property Data $Data
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class DataController extends AppController {


	var $uses = array('Application', 'Data');
/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Session');

	public $helpers = array('Js');//,'AjaxMultiUpload.Upload');


	public function manage($id=null){		
		if (!$this->Application->exists($id)) {
			throw new NotFoundException(__('Invalid data'));
		}
		$app = $this->Application->find('first', array('conditions'=>array('Application.id' => $id)));

		if ($this->request->is('post')) {
			//esto es que estoy subiendo el fichero
			$name = $this->request->data['name'];
			$type = $this->request->data['type'];
			$objFile = $_FILES["uploaded"];
            $fileName = basename( $objFile["name"] );
            $strPath = $_SERVER['CONTEXT_DOCUMENT_ROOT'] . DS . 'pool' . DS;
            if (!is_dir($strPath)) {
                mkdir($strPath);
                chgrp($strPath, "www-data");
                chmod($strPath, 0777);
            }
            $strPath .= $app['Application']['name'] . DS;
            if (!is_dir($strPath)) {
                mkdir($strPath);
                chgrp($strPath, "www-data");
                chmod($strPath, 0777);
            }
            $strPath .= $app['Application']['version'] . DS;
            if (!is_dir($strPath)) {
                mkdir($strPath);
                chgrp($strPath, "www-data");
                chmod($strPath, 0777);
            }
            // Se crea los datos a almacenar y se guardan
            $data = array(
            	'Data' => array(
            		'application_id' => $id,
            		'name' => $name,
            		'filename' => $fileName,
            		'type' => $type,
            		'verificate' => 0
            		));
            $this->Data->create();
            if($this->Data->save($data)){
            	//si se salvo en la BD entonces procedo a mover el fichero a su destino final
            	$strPath .= $this->Data->id . '.zip';
            	if(!copy($objFile["tmp_name"], $strPath)){
            		$this->Session->setFlash('No se pudo colocar el fichero elimine el dato insertado manualmente.');
            		//Aqui puedo eliminar el dato yo mismo
            		//$this->Data-delete();
            	}else{
            		$app = $this->Application->find('first', array('conditions'=>array('Application.id' => $id)));
            	}

            }

		}else{
			// esto es que estoy mostrando el formulario
		}

		$this->set('app', $app);
	}


	public function upload($id=null){
		//subo o manejo los datos para la aplicacion con el id que me pasan
	}




/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Data->recursive = 0;
		$this->set('data', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Data->exists($id)) {
			throw new NotFoundException(__('Invalid data'));
		}
		$options = array('conditions' => array('Data.' . $this->Data->primaryKey => $id));
		$this->set('data', $this->Data->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Data->create();
			if ($this->Data->save($this->request->data)) {
				$this->Session->setFlash(__('The data has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The data could not be saved. Please, try again.'));
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
		if (!$this->Data->exists($id)) {
			throw new NotFoundException(__('Invalid data'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Data->save($this->request->data)) {
				$this->Session->setFlash(__('The data has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The data could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Data.' . $this->Data->primaryKey => $id));
			$this->request->data = $this->Data->find('first', $options);
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
		$this->Data->id = $id;
		if (!$this->Data->exists()) {
			throw new NotFoundException(__('Invalid data'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Data->delete()) {
			$this->Session->setFlash(__('The data has been deleted.'));
		} else {
			$this->Session->setFlash(__('The data could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
