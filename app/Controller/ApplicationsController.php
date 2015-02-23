<?php
App::uses('AppController', 'Controller');
/**
 * Applications Controller
 *
 * @property Application $Application
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class ApplicationsController extends AppController {

    var $uses = array('Application', 'Version', 'Apk', 'History');
/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Session');

    public function beforeFilter(){
        parent::beforeFilter();
//        if($this->Auth->user('role') != 'admin'){
//            $this->Session->setFlash('No está autorizado a consultar esa página.');
//            return $this->redirect(array('controller' => 'applications', 'action' => 'repo'));
//        }
        $this->Auth->allow(
            'repo',
            'detail',
            'downloadApp',
            'downloadVersion'
        );
        $this->Paginator->settings=array(
            'limit'=>6,
            'order' => array(
                'Application.label' => 'asc'
            )
        );
    }

    public function isAuthorized($user) {
       if($this->action ===  "repo" || $this->action ===  "detail" )
           return true;
        return parent::isAuthorized($user);
    }

/**
 * index method
 *
 * @return void
 */
	public function index() {
//        var_dump( $_SERVER["SERVER_SOFTWARE"]);
//        if($this->esWindow()){
//            echo "Window";
//        }else
//            echo "Linux";

//        $this->request
		$this->Application->recursive = 0;
		$this->set('applications', $this->Paginator->paginate());
	}



    public function repo($search = null) {
        $this->set('title_for_layout','Repositorio de aplicaciones');
        $limit = 36;
//        var_dump($_SERVER);
        //it1
        //aqui hay que verificar si se esta autenticado si es asi mostrar todas
        //si no se esta autenticado mostrar solo las validas
        $settings =array(
            'limit'=>$limit ,
            'order' => array(
                'Application.label' => 'asc'
            ));
        // var_dump($_SERVER);

        if(isset($search))
        {
            if(!isset($this->Auth->user()['username'])){
                $settings =array(
                    'limit'=>$limit ,
                    //'conditions' => array('Apk.category is not null', 'Apk.category is not equal to \"Untrusted\"'),
                    'conditions' => array(
                        'Application.category is not null',
                        'Application.category <>' => 'Untrusted',
                        'OR' => array(
                            'Application.id LIKE' => '%' . $search . '%',
                            'Application.label LIKE' => '%' . $search . '%'
                        )
                    ),
                    'order' => array(
                        'Application.label' => 'asc'
                    ));
            }else{
                $settings =array(
                    'limit'=>$limit ,
                    //'conditions' => array('Apk.category is not null', 'Apk.category is not equal to \"Untrusted\"'),
                    'conditions' => array(
                        'OR' => array(
                            'Application.id LIKE' => '%' . $search . '%',
                            'Application.label LIKE' => '%' . $search . '%'
                        )
                    ),
                    'order' => array(
                        'Application.label' => 'asc'
                    ));
            }
        }else{
            if(!isset($this->Auth->user()['username'])){
                $settings =array(
                    'limit'=>$limit ,
                    'conditions' => array('Application.category is not null', 'Application.category <>' => 'Untrusted', 'Application.category <>' => 'Terceros'),
                    'order' => array(
                        'Application.label' => 'asc'
                    ));
            }
        }

//        if(!isset($this->Auth->user()['username'])){
        $this->Paginator->settings=$settings;
//        }

        //$this->layout = 'frontend';
        $this->Application->recursive = 0;
        $this->set('apks', $this->Paginator->paginate());
        $this->set('search',$search);
    }

    public function downloadApp($id = null){
        if (!$this->Application->exists($id)) {
            throw new NotFoundException(__('Invalid apk'));
        }
        $label = $id;
        $this->layout = null;
        $this->viewClass = 'Media';
        $file = $this->Application->find('first',array('conditions'=>array('Application.id'=>$id)));
        $down = $file['Application']['downloads'] + 1;
        //Salvar el apk con el aumento de el campo downloads para indicar que hubo un cambio mas
        $this->Application->id = $id;
        $this->Application->saveField('downloads', $down);
        if ($this->Apk->exists($id)) {
            $this->Apk->id = $id;
            $this->Apk->saveField('downloads', $down);
        }
        //$data1 = $this->request->header('EXTRA_INFO');
        if(isset($this->request->data['client']))
            $client = $this->request->data['client'];
        else{
            $client = 'directDownload';
            throw new NotFoundException(__('App client obsolete'));
            //echo "error";
            //die();
        }
        $dataHistory = array('History' => array(
            'name' =>  $file['Application']['id'],
            'ip' => $this->request->clientIp(),
            'client' => $client
        ));
        $this->History->save($dataHistory);
        $label = $file['Application']['label'];
        $params = array(
            'id'        => '',
            'name'      => $label . '.apk',
            'extension' => 'apk',
            'mimeType'  => 'application/vnd.android.package-archive',
            'path'  =>   'webroot/pool/'. $id . '/'. $file['Application']['version'] . '/' . $id  .'.apk',
            'download'=>true
        );
        $this->response->type('application/vnd.android.package-archive');
        $this->set($params);
    }

    public function downloadVersion($id = null){
        if (!$this->Version->exists($id)) {
            throw new NotFoundException(__('Invalid apk'));
        }
        $label = $id;
        $this->layout = null;
        $this->viewClass = 'Media';
        $file = $this->Version->find('first',array('conditions'=>array('Version.id'=>$id)));
        $down = $file['Version']['downloads'] + 1;
        //Salvar el apk con el aumento de el campo downloads para indicar que hubo un cambio mas
        $this->Version->id = $id;
        $this->Version->saveField('downloads', $down);
        $dataHistory = array('History' => array(
            'name' =>  $file['Version']['application_id'],
            'ip' => $this->request->clientIp(),
            'client' => "Web - (Version)"
        ));
        $this->History->save($dataHistory);
        $label = $file['Version']['label'];
        $params = array(
            'id'        => '',
            'name'      => $label . '.apk',
            'extension' => 'apk',
            'mimeType'  => 'application/vnd.android.package-archive',
            'path'  =>   'webroot/pool/'. $file['Version']['application_id'] . '/'. $file['Version']['version'] . '/' . $file['Version']['application_id']  .'.apk',
            'download'=>true
        );
        $this->response->type('application/vnd.android.package-archive');
        $this->set($params);
    }

    public function detail($id = null) {
        if (!$this->Application->exists($id)) {
            throw new NotFoundException(__('Invalid apk'));
        }

        $options = array('conditions' => array('Application.' . $this->Application->primaryKey => $id));
        $this->set('apk', $this->Application->find('first', $options));
    }

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Application->exists($id)) {
			throw new NotFoundException(__('Invalid application'));
		}
		$options = array('conditions' => array('Application.' . $this->Application->primaryKey => $id));
		$this->set('application', $this->Application->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Application->create();
			if ($this->Application->save($this->request->data)) {
				$this->Session->setFlash(__('The application has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The application could not be saved. Please, try again.'));
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
		if (!$this->Application->exists($id)) {
			throw new NotFoundException(__('Invalid application'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Application->save($this->request->data)) {
				$this->Session->setFlash(__('The application has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The application could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Application.' . $this->Application->primaryKey => $id));
			$this->request->data = $this->Application->find('first', $options);
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
		$this->Application->id = $id;
		if (!$this->Application->exists()) {
			throw new NotFoundException(__('Invalid application'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Application->delete()) {
			$this->Session->setFlash(__('The application has been deleted.'));
		} else {
			$this->Session->setFlash(__('The application could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
