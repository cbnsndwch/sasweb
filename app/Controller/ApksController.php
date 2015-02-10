<?php
App::uses('AppController', 'Controller');
/**
 * Apks Controller
 *
 * @property Apk $Apk
 * @property PaginatorComponent $Paginator
 */
class ApksController extends AppController {

    var $uses = array('Apk','History','Generalcoment');
/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');//,'DebugKit.Toolbar');

    public $helpers = array('Html', 'Form');

    public function beforeFilter(){
        parent::beforeFilter();
//        if($this->Auth->user('role') != 'admin'){
//            $this->Session->setFlash('No está autorizado a consultar esa página.');
//            return $this->redirect(array('controller' => 'applications', 'action' => 'repo'));
//        }
        $this->Auth->allow(
            'repo', 'detail'
        );
        $this->Paginator->settings=array(
            'limit'=>6,
            'order' => array(
                'Apk.label' => 'asc'
            )
        );
    }
    public function isAuthorized($user) {
        // All registered users can add posts
//        if ($this->action === 'add') {
//        return true;
//        }
//        // The owner of a post can edit and delete it
//        if (in_array($this->action, array('edit', 'delete'))) {
//            $postId = $this->request->params['pass'][0];
//        if ($this->Post->isOwnedBy($postId, $user['id'])) {
//                return true;
//            }
//        }
        return parent::isAuthorized($user);
    }
    
    /**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Apk->recursive = 0;

//        var_dump($this->Paginator->paginate());
		$this->set('apks', $this->Paginator->paginate());
	}

    public function repo($search = null) {
        //it1
        //aqui hay que verificar si se esta autenticado si es asi mostrar todas
        //si no se esta autenticado mostrar solo las validas

        $settings =array(
            'limit'=>6,
            //'conditions' => array('Apk.category is not null', 'Apk.category is not equal to \"Untrusted\"'),
            //'conditions' => array('Apk.category is not null', 'Apk.category <>' => 'Untrusted'),
            'order' => array(
                'Apk.label' => 'asc'
            ));

        if(isset($search))
        {
            if(!isset($this->Auth->user()['username'])){
                $settings =array(
                    'limit'=>6,
                    //'conditions' => array('Apk.category is not null', 'Apk.category is not equal to \"Untrusted\"'),
                    'conditions' => array(
                        'Apk.category is not null',
                        'Apk.category <>' => 'Untrusted',
                        'OR' => array(
                            'Apk.id LIKE' => '%' . $search . '%',
                            'Apk.label LIKE' => '%' . $search . '%'
                        )
                    ),
                    'order' => array(
                        'Apk.label' => 'asc'
                    ));
            }else{
                $settings =array(
                    'limit'=>6,
                    //'conditions' => array('Apk.category is not null', 'Apk.category is not equal to \"Untrusted\"'),
                    'conditions' => array(
                        'OR' => array(
                            'Apk.id LIKE' => '%' . $search . '%',
                            'Apk.label LIKE' => '%' . $search . '%'
                        )
                    ),
                    'order' => array(
                        'Apk.label' => 'asc'
                    ));
            }
        }else{
            if(!isset($this->Auth->user()['username'])){
                $settings =array(
                    'limit'=>6,
                    //'conditions' => array('Apk.category is not null', 'Apk.category is not equal to \"Untrusted\"'),
                    'conditions' => array('Apk.category is not null', 'Apk.category <>' => 'Untrusted'),
                    'order' => array(
                        'Apk.label' => 'asc'
                    ));
            }
        }

//        if(!isset($this->Auth->user()['username'])){
            $this->Paginator->settings=$settings;
//        }

        //$this->layout = 'frontend';
        $this->Apk->recursive = 0;
        $this->set('apks', $this->Paginator->paginate());
    }



    public function test() {
        $this->layout = null;
        $this->viewClass = 'Media';

//        $test = "'sssssss'";
        //echo 'aapt dump --values badging ' . '' . ' | grep ^sdkVersion: | cut -d' . '"' . '\'' . '" -f2 | head -1';
//        $count = strlen($test);
//        echo substr($test,1, $count- 2);

        //echo strlen($test);
        var_dump($this->apk_info('soft\\android.tether.apk'));
    }


/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Apk->exists($id)) {
			throw new NotFoundException(__('Invalid apk'));
		}

		$options = array('conditions' => array('Apk.' . $this->Apk->primaryKey => $id));
		$this->set('apk', $this->Apk->find('first', $options));
	}

    public function detail($id = null) {
        if (!$this->Apk->exists($id)) {
            throw new NotFoundException(__('Invalid apk'));
        }

        $options = array('conditions' => array('Apk.' . $this->Apk->primaryKey => $id));
        $this->set('apk', $this->Apk->find('first', $options));
    }

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Apk->create();
			if ($this->Apk->save($this->request->data)) {
				$this->Session->setFlash(__('The apk has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The apk could not be saved. Please, try again.'));
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
		if (!$this->Apk->exists($id)) {
			throw new NotFoundException(__('Invalid apk'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Apk->save($this->request->data)) {
				$this->Session->setFlash(__('The apk has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The apk could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Apk.' . $this->Apk->primaryKey => $id));
			$this->request->data = $this->Apk->find('first', $options);
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
		$this->Apk->id = $id;
		if (!$this->Apk->exists()) {
			throw new NotFoundException(__('Invalid apk'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Apk->delete()) {
			$this->Session->setFlash(__('The apk has been deleted.'));
		} else {
			$this->Session->setFlash(__('The apk could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}

}
