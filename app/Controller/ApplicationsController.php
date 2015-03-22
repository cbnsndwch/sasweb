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

    var $uses = array('Application', 'Version', 'Apk', 'Generalcoment', 'History', 'Category','Configuration', 'Coment');
/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Session','DebugKit.Toolbar');

    public function beforeFilter(){
        parent::beforeFilter();
//        if($this->Auth->user('role') != 'admin'){
//            $this->Session->setFlash('No está autorizado a consultar esa página.');
//            return $this->redirect(array('controller' => 'applications', 'action' => 'repo'));
//        }
        $this->Auth->allow(
            'repo',
            'reponews',
            'reporecommended',
            'repoverificate',
            'comments',
            'addcomment',
            'generalcomments',
            'detail',
            'downloadApp',
            'downloadData',
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

    public function verificate($id = null){
        if (!$this->Application->exists($id)) {
            $this->redirect(array('action' => 'detail',$id));
        } else{
            $options = array('conditions' => array('Application.id' => $id));
            $app = $this->Application->find('first', $options);
            $app['Application']['verificate'] = 1;
            //Aqui se puede agregar tambien quien lo verifico
            if($this->Application->save($app)){
                $this->Session->setFlash('Application verificada.');
                $this->redirect(array('action' => 'detail',$id));
            }            
        }
    }

     public function recommended($id = null){
        if (!$this->Application->exists($id)) {
            $this->redirect(array('action' => 'detail',$id));
        } else{
            $options = array('conditions' => array('Application.id' => $id));
            $app = $this->Application->find('first', $options);
            $app['Application']['recommended'] = 1;
            //Aqui se puede agregar tambien quien lo verifico
            if($this->Application->save($app)){
                $this->Session->setFlash('Application verificada.');
                $this->redirect(array('action' => 'detail',$id));
            }            
        }
    }

    public function comments($id = null){
        $this->set('title_for_layout',' Comentarios');
        if (!$this->Application->exists($id)) {
            throw new NotFoundException(__('Invalid apk'));
        }      
        $options = array('conditions' => array('Application.' . $this->Application->primaryKey => $id));
        $this->Application->recursive = 2;
        $apk = $this->Application->find('first', $options);   
        //var_dump($apk);
        $this->set('apk', $apk);
    }

    public function addcomment($id = null){
        if (!$this->Application->exists($id)) {
            $this->redirect(array('action' => 'comments',$id));
        } else{
            $coment = $_POST['coment'];

            $insert = array(
                'Coment' => array(
                        'applications_id' => $id,
                        'ip' => $this->request->clientIp(),
                        'coment' => $coment,
                        'visible' => 1

                    )
                );
            
            if($this->Auth->loggedIn())
                $insert['Coment']['users_id'] = $this->Auth->user()['id'];

            $this->Coment->create();
            if($this->Coment->save($insert)){
               //$this->Session->setFlash(__('Se ha almacenado el comentario con exito.'));
            }else{
               // $this->Session->setFlash(__('No se pudo almacenar el comentario.'));
            }

             $this->redirect(array('action' => 'comments',$id));
        }
    }

    public function generalcomments(){
        $this->set('title_for_layout','Comentarios sobre Sas');

        // $options = array('conditions' => array('Application.' . $this->Application->primaryKey => $id));
        // $this->Application->recursive = 2;
        // $apk = $this->Application->find('first', $options);   
        // //var_dump($apk);
        // $this->set('coments', $apk);
        
    }

    public function addgeneralcomment($id = null){
        
        $coment = $_POST['coment'];

        $insert = array(
            'Generalcoment' => array(
                    'ip' => $this->request->clientIp(),
                    'coment' => $coment,
                    'client' => 'web'

                )
            );
        
        if($this->Auth->loggedIn())
            $insert['Generalcoment']['usertag'] = $this->Auth->user()['hash'];//por ahora luego aqui poner id

        $this->Generalcoment->create();
        if($this->Generalcoment->save($insert)){
           //$this->Session->setFlash(__('Se ha almacenado el comentario con exito.'));
        }else{
           // $this->Session->setFlash(__('No se pudo almacenar el comentario.'));
        }

         $this->redirect(array('action' => 'generalcomments'));
        
    }


    public function repo($cat = -1, $search = null) {
        $title= "sssss";
        $this->set('title_for_layout','Repositorio de aplicaciones');
        $limit = 6;
        $settings =array(
            'limit'=>$limit ,
            'order' => array(
                'Application.label' => 'asc'
            ));
        if(isset($search))
        {           
            $settings['conditions'] = array(
                    'OR' => array(
                        'Application.id LIKE' => '%' . $search . '%',
                        'Application.label LIKE' => '%' . $search . '%'
                    )
                );           
        }
        if($cat != -1){
             $settings['conditions']['Application.categories_id'] = $cat;
        }
        if(!$this->Auth->loggedIn()){ //por ahora no hay restrincciones de este tipo todas las app tienen 0 pero por si acaso
            $settings['conditions']['Application.only_logged'] = 0;
        }
        $this->Paginator->settings=$settings;
        //poner las categorias para el menu
        $categorys =  $this->Category->find('all', array());
        // var_dump($categorys);
        $this->set('category',$categorys);
        $this->set('catsel',$cat);

        //$this->layout = 'frontend';
        $this->Application->recursive = 0;
        $this->set('apks', $this->Paginator->paginate());
        $this->set('search',$search);
    }

    public function reponews($cat = -1, $search = null) {
        $title= "sssss";
        $this->set('title_for_layout','Aplicaciones nuevas');
        $limit = 6;
        //pido la configuracion
        $config = $this->Configuration->find('first', array('conditions' => array('Configuration.id'=> 1)));
        //este es la cantidad de dias pasados que se cogeran para calcular los nuevos, esto debe estar en la tabla de conf o del usuario
        $dayToNew = $config["Configuration"]['days_to_new'];
        $date = date_create('now');
        date_sub($date, date_interval_create_from_date_string($dayToNew . ' days'));
        // var_dump($date->format('Y-m-d H:i:s'));
        //  var_dump($date);
        $settings =array(
            'limit'=>$limit ,
            'conditions' => array(
                'Application.created >= "' . $date->format('Y-m-d H:i:s') . '"' ,
                ),
            'order' => array(
                'Application.label' => 'asc'
            ));
        if(isset($search))
        {           
            $settings['conditions']['OR'] = array(
                        'Application.id LIKE' => '%' . $search . '%',
                        'Application.label LIKE' => '%' . $search . '%'
                    );           
        }
        if($cat != -1){
             $settings['conditions']['Application.categories_id'] = $cat;
        }
        if(!$this->Auth->loggedIn()){ //por ahora no hay restrincciones de este tipo todas las app tienen 0 pero por si acaso
            $settings['conditions']['Application.only_logged'] = 0;
        }
        $this->Paginator->settings=$settings;
        //poner las categorias para el menu
        $categorys =  $this->Category->find('all', array());
        // var_dump($categorys);
        $this->set('category',$categorys);
        $this->set('catsel',$cat);

        //$this->layout = 'frontend';
        $this->Application->recursive = 0;
        $this->set('apks', $this->Paginator->paginate());
        $this->set('search',$search);
    }

    public function reporecommended($cat = -1, $search = null) {
        $title= "sssss";
        $this->set('title_for_layout','Aplicaciones recomendadas');
        $limit = 6;
        //pido la configuracion
        $config = $this->Configuration->find('first', array('conditions' => array('Configuration.id'=> 1)));

        $settings =array(
            'limit'=>$limit ,
            'conditions' => array(
                'Application.recommended' => 1,
                ),
            'order' => array(
                'Application.label' => 'asc'
            ));
        if(isset($search))
        {           
            $settings['conditions']['OR'] = array(
                        'Application.id LIKE' => '%' . $search . '%',
                        'Application.label LIKE' => '%' . $search . '%'
                    );           
        }
        if($cat != -1){
             $settings['conditions']['Application.categories_id'] = $cat;
        }
        if(!$this->Auth->loggedIn()){ //por ahora no hay restrincciones de este tipo todas las app tienen 0 pero por si acaso
            $settings['conditions']['Application.only_logged'] = 0;
        }
        $this->Paginator->settings=$settings;
        //poner las categorias para el menu
        $categorys =  $this->Category->find('all', array());
        // var_dump($categorys);
        $this->set('category',$categorys);
        $this->set('catsel',$cat);

        //$this->layout = 'frontend';
        $this->Application->recursive = 0;
        $this->set('apks', $this->Paginator->paginate());
        $this->set('search',$search);
    }

     public function repoverificate($cat = -1, $search = null) {
        $title= "sssss";
        $this->set('title_for_layout','Aplicaciones recomendadas');
        $limit = 6;
        //pido la configuracion
        $config = $this->Configuration->find('first', array('conditions' => array('Configuration.id'=> 1)));

        $settings =array(
            'limit'=>$limit ,
            'conditions' => array(
                'Application.verificate' => 1,
                ),
            'order' => array(
                'Application.label' => 'asc'
            ));
        if(isset($search))
        {           
            $settings['conditions']['OR'] = array(
                        'Application.id LIKE' => '%' . $search . '%',
                        'Application.label LIKE' => '%' . $search . '%'
                    );           
        }
        if($cat != -1){
             $settings['conditions']['Application.categories_id'] = $cat;
        }
        if(!$this->Auth->loggedIn()){ //por ahora no hay restrincciones de este tipo todas las app tienen 0 pero por si acaso
            $settings['conditions']['Application.only_logged'] = 0;
        }
        $this->Paginator->settings=$settings;
        //poner las categorias para el menu
        $categorys =  $this->Category->find('all', array());
        // var_dump($categorys);
        $this->set('category',$categorys);
        $this->set('catsel',$cat);

        //$this->layout = 'frontend';
        $this->Application->recursive = 0;
        $this->set('apks', $this->Paginator->paginate());
        $this->set('search',$search);
    }

    public function downloadData($id = null){
        if (!$this->Application->exists($id)) {
            throw new NotFoundException(__('Invalid apk'));
        }
        $label = $id;
        $this->layout = null;
        $this->viewClass = 'Media';
        $file = $this->Application->find('first',array('conditions'=>array('Application.id'=>$id)));
        $label = $file['Application']['label'];
        $params = array(
            'id'        => '',
            'name'      => $label ,
            'extension' => 'zip',
            'mimeType'  => 'application/zip',
            'path'  =>   'webroot/pool/'. $id . '/'. $file['Application']['version'] . '/' . $id  .'.zip',
            'download'=>true
        );
        $this->response->type('application/zip');
        $this->set($params);
    }

    public function verificateData($id = null){
        if (!$this->Application->exists($id)) {
            throw new NotFoundException(__('Invalid apk'));
        }
        $strDest = $_SERVER['CONTEXT_DOCUMENT_ROOT'] .'pool' . DS;
        $file = $this->Application->find('first',array('conditions'=>array('Application.id'=>$id)));
        $strDest .= $file['Application']['id'] . DS . $file['Application']['version'] . DS . $file['Application']['id'] . '.zip';        
        if(file_exists($strDest)){
            //los datos estan ok
            $this->Application->id = $id;
            $this->Application->saveField('have_data', 1);
        }else{
            $this->Session->setFlash('Antes de activar los datos debe colocar lel archivo .zip en la carpeta correcta. Esta version no incluye el control automatico de los datos.');
        }
        return $this->redirect(array('action' => 'detail', $id));
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

        if(isset($this->request->data['client']))
            $client = $this->request->data['client'];
        else{
            $client = 'directDownload';
            //throw new NotFoundException(__('App client obsolete'));
            //echo "error";
            //die();
        }
        $dataHistory = array('History' => array(
            'name' =>  $file['Application']['id'] .'-'. $file['Application']['code'],
            'ip' => $this->request->clientIp(),
            'client' => $client
        ));
        $this->History->save($dataHistory);
        $label = $file['Application']['label'];
        $params = array(
            'id'        => '',
            'name'      => $label ,
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
            'name'      => $label ,
            'extension' => 'apk',
            'mimeType'  => 'application/vnd.android.package-archive',
            'path'  =>   'webroot/pool/'. $file['Version']['application_id'] . '/'. $file['Version']['version'] . '/' . $file['Version']['application_id']  .'.apk',
            'download'=>true
        );
        $this->response->type('application/vnd.android.package-archive');
        $this->set($params);
    }

    public function detail($id = null) {

        $this->set('title_for_layout','Detalles');
        if (!$this->Application->exists($id)) {
            throw new NotFoundException(__('Invalid apk'));
        }
        

        $options = array('conditions' => array('Application.' . $this->Application->primaryKey => $id));
        $apk = $this->Application->find('first', $options);
        //buscar las aplicaciones relacionadas
        if($apk['Category']['id'] !== 1){

            $count = $this->Application->find('count', array('conditions' => array(
                    'Application.categories_id' => $apk['Category']['id'],
                    'Application.id != ' . "'" .$apk['Application']['id'] . "'"
                )));

            $result = rand(0,$count - 3);   
            //aqui cojo 6 aplicaciones que sean de la miama categoria
            $related = $this->Application->find('all', array(
                'conditions' => array(
                    'Application.categories_id' => $apk['Category']['id'],
                    'Application.id != ' . "'" .$apk['Application']['id'] . "'"
                ), 
                'limit' => 3,
                'offset' => $result
            ));// array($result , $result + 3)
            $this->set('related', $related);
        }
        $this->set('apk', $apk);
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
