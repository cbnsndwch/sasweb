<?php
App::uses('AppController', 'Controller');
/**
 * Users Controller
 *
 * @property User $User
 * @property PaginatorComponent $Paginator
 */
class UsersController extends AppController {

/**
 * Components
 *
 * @var array
 */
    public $components = array(
        'Paginator',
        'Session',
//        'Auth' => array(
//            'loginRedirect' => array(
//                'controller' => 'posts',
//                'action' => 'index'
//            ),
//            'logoutRedirect' => array(
//                'controller' => 'pages',
//                'action' => 'display',
//                'home'
//            )
//        )
    );

//    public function beforeFilter() {
//        parent::beforeFilter();
//        if($this->Auth->user('role') != 'admin'){
//            $this->Session->setFlash('No está autorizado a consultar esa página.');
//            return $this->redirect(array('controller' => 'applications', 'action' => 'repo'));
//        }
//    }

//    public function beforeFilter() {
//        parent::beforeFilter();
//        // Allow users to register and logout.
//        $this->Auth->allow('add', 'logout'/*,'index'*/);
//    }

//    public function isAuthorized($user) {
//        if(in_array($this->action, array('edit', 'delete'))){
//            if($user['id'] != $this->request->params['pass'][0]){
//                return false;
//            }
//        }
//        return true;
//    }

     public function isAuthorized($user) {
     	if(in_array($this->action, array('changepassword'))){
     		if($user["id"] != $this->request->params['pass'][0]){
     			return false;
     		}else{
     			return true;
     		}
     	}

        parent::beforeFilter();        
    }

    public function login() {
    	$this->layout = null;
        if ($this->request->is('post')) {
            if ($this->Auth->login()) {
                return $this->redirect($this->Auth->redirect());
            }
            $this->Session->setFlash(__('Usuario o clave invalidas, intentelo nuevamente.'));
        }
    }
    public function logout() {
        return $this->redirect($this->Auth->logout());
    }

    public function changepassword($id = null){
    	if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->request->is(array('post', 'put'))) {
			//debug($this->request->data);
			$this->User->id = $id;
			if ($this->User->saveField('password' , $this->request->data['User']['password'])) {
				$this->Session->setFlash(__('La clave fue almacenada con exito.'));
				unset($this->request->data['User']['password']);
				return $this->redirect(array('controller' => 'applications', 'action' => 'repo'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'));
			}
			unset($this->request->data['User']['password']);
		} else {
			$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
			$this->request->data = $this->User->find('first', $options);
			unset($this->request->data['User']['password']);
    		// unset($this->request->data['User']['pwd_repeat']);
		}
    }
/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->User->recursive = 0;
		$this->set('users', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Invalid user'));
		}
		$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
		$this->set('user', $this->User->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->User->create();
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('The user has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'));
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
		if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('The user has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
			$this->request->data = $this->User->find('first', $options);
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
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->User->delete()) {
			$this->Session->setFlash(__('The user has been deleted.'));
		} else {
			$this->Session->setFlash(__('The user could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}

    public function devicelogin() {
        $this->layout = null;
        $tag = $_POST['tag'];
        $response = array("tag" => $tag, "success" => 0, "error" => 0);

        $username = $_POST['email'];
        $password = $_POST['password'];

        $options = array(
            'conditions' => array(
                'username' => $username
            )
        );

        $user = $this->User->find('first', $options);
        if ($user != false) {
            // usuario encontrado
            // marcamos el json como correcto con success = 1
            $response["success"] = 1;
            $response["uid"] = $user["User"]["id"];
            $response["user"]["username"] = $user["User"]["username"];
            $response["user"]["password"] = $user["User"]["password"];
            $response["user"]["created_at"] = $user["User"]["created"];
            echo json_encode($response);
        }else{
            // usuario no encontrado
            // marcamos el json con error = 1
            $response["error"] = 1;
            $response["error_msg"] = "Email o password incorrecto!";
            echo json_encode($response);
        }


        die();

    }

    public function deviceregister() {

        echo "deviceregister";
        die();
    }


}
