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

    var $uses = array('Application', 'Generalcoment', 'History', 'Category','Configuration', 'Coment');
/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Session');//,'DebugKit.Toolbar');

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
            'downloadVersion',
            'repodownloads'
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
        $file = $this->Application->find('first',array('conditions'=>array('Application.name'=>$id)));
        if (!isset($file['Application'])) {
            $this->redirect(array('action' => 'detail',$id));
        }else{
            $options = array('conditions' => array('Application.name' => $id));
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
        $file = $this->Application->find('first',array('conditions'=>array('Application.name'=>$id)));
        if (!isset($file['Application'])) {
            $this->redirect(array('action' => 'detail',$id));
        } else{
            $options = array('conditions' => array('Application.name' => $id));
            $app = $this->Application->find('first', $options);
            $app['Application']['recommended'] = 1;
            //Aqui se puede agregar tambien quien lo verifico
            if($this->Application->save($app)){
                $this->Session->setFlash('Application recomendada.');
                $this->redirect(array('action' => 'detail',$id));
            }            
        }
    }

    public function comments($id = null){
        $this->set('title_for_layout',' Comentarios');
        $file = $this->Application->find('first',array('conditions'=>array('Application.name'=>$id)));
        if (!isset($file['Application'])) {
            throw new NotFoundException(__('Invalid apk'));
        }      
        $options = array('conditions' => array('Application.name' => $id));
        $this->Application->recursive = 2;
        $apk = $this->Application->find('first', $options);   
        //var_dump($apk);
        $this->set('apk', $apk);
    }

    public function addcomment($id = null){
        $file = $this->Application->find('first',array('conditions'=>array('Application.name'=>$id)));
        if (!isset($file['Application'])) {
            $this->redirect(array('action' => 'comments',$id));
        } else{
            $coment = $_POST['coment'];
            $insert = array(
                'Coment' => array(
                        'applications_id' => $file['Application']['id'],
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
        $this->set('title_for_layout','Repositorio de aplicaciones');
        $limit = 12;
        $settings =array(
            'limit'=>$limit ,
            'conditions' => array('Application.parent_id is null'),
            'order' => array(
                'Application.label' => 'asc'
            ));
        if(isset($search))
        {           
            $settings['conditions']['OR'] = array(
                        'Application.name LIKE' => '%' . $search . '%',
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

    public function repodownloads($cat = -1, $search = null) {
        $this->set('title_for_layout','Ordenadas por descarga');
        $limit = 12;
        $settings =array(
            'limit'=>$limit ,
            'conditions' => array('Application.parent_id is null'),
            'order' => array(
                'Application.downloads' => 'desc'
            ));
        if(isset($search))
        {           
            $settings['conditions']['OR'] = array(
                        'Application.name LIKE' => '%' . $search . '%',
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

    public function reponews($cat = -1, $search = null) {
        $title= "sssss";
        $this->set('title_for_layout','Aplicaciones nuevas');
        $limit = 12;
        //pido la configuracion
        $config = $this->Configuration->find('first', array('conditions' => array('Configuration.id'=> 1)));
        //este es la cantidad de dias pasados que se cogeran para calcular los nuevos, esto debe estar en la tabla de conf o del usuario
        $dayToNew = $config["Configuration"]['days_to_new'];
        $date = date_create('now');
        date_sub($date, date_interval_create_from_date_string($dayToNew . ' days'));
        

        $settings =array(
            'limit'=>$limit ,
            'conditions' => array(
                'Application.parent_id is null',
                'Application.created >= "' . $date->format('Y-m-d H:i:s') . '"' ,
                ),
            'order' => array(
                'Application.created' => 'desc'
            ));
        if(isset($search))
        {           
            $settings['conditions']['OR'] = array(
                        'Application.name LIKE' => '%' . $search . '%',
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
        $limit = 12;
        $settings =array(
            'limit'=>$limit ,
            'conditions' => array(
                'Application.parent_id is null',
                'Application.recommended' => 1
                ),
            'order' => array(
                'Application.label' => 'asc'
            ));
        if(isset($search))
        {           
            $settings['conditions']['OR'] = array(
                        'Application.name LIKE' => '%' . $search . '%',
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
        $limit = 12;
        $settings =array(
            'limit'=>$limit ,
            'conditions' => array(
                'Application.parent_id is null',
                'Application.verificate' => 1,
                ),
            'order' => array(
                'Application.label' => 'asc'
            ));
        if(isset($search))
        {           
            $settings['conditions']['OR'] = array(
                        'Application.name LIKE' => '%' . $search . '%',
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
        $file = $this->Application->find('first',array('conditions'=>array('Application.name'=>$id)));
        if (!isset($file['Application'])) {
            throw new NotFoundException(__('Invalid apk'));
        }        
        $this->layout = null;
        $this->viewClass = 'Media';
        $label = $file['Application']['label'];
        $name =  $file['Application']['name'];
        $params = array(
            'id'        => '',
            // 'name'      => $label ,
            // 'extension' => 'zip',
            'mimeType'  => 'application/zip',
            'path'  =>   'webroot/pool/'. $name . '/'. $file['Application']['version'] . '/' . $name  .'.zip',
            'download'=>true
        );
        $this->response->type('application/zip');
        $this->set($params);
    }

    public function verificateData($id = null){
        $file = $this->Application->find('first',array('conditions'=>array('Application.name'=>$id)));
        if (!isset($file['Application'])) {
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

    public function downloadApp($id = null, $version = null){

        $options = array(
            'conditions'=>array('Application.name' => $id)
            );
        if(isset($version)){//es que quiero descargar una version en especifico
            $options['conditions']['Application.version'] = $version;
        }else{//es que quiero descargar la mas reciente
            $options['order']['Application.version'] = 'desc';
        }

        $file = $this->Application->find('first',$options);
        if (!isset($file['Application'])) {
            throw new NotFoundException(__('Invalid apk'));
        }        
        $this->layout = null;
        $this->viewClass = 'Media';
        $label = $file['Application']['label'];
        $down = $file['Application']['downloads'] + 1;
        //Salvar el apk con el aumento de el campo downloads para indicar que hubo un cambio mas
        $this->Application->id = $file['Application']['id'];
        $this->Application->saveField('downloads', $down);

        if(isset($this->request->data['client']))
            $client = $this->request->data['client'];
        else{
            $client = 'WebAccess';
            //throw new NotFoundException(__('App client obsolete'));
            //echo "error";
            //die();
        }
        $dataHistory = array('History' => array(
            'name' =>  $file['Application']['name'] ,
            'version' => $file['Application']['code'],
            'ip' => $this->request->clientIp(),
            'client' => $client
        ));
        $this->History->save($dataHistory);
        $label = $file['Application']['label'];
        $name =  $file['Application']['name'];
        $params = array(
            'id'        => '',
            // 'name'      => $label . '.apk',
            // 'extension' => 'apk',
            'mimeType'  => 'application/vnd.android.package-archive',
            'path'  =>   'webroot/pool/'. $name . '/'. $file['Application']['version'] . '/' . $name  .'.apk',
            'download'=>true
        );
        $this->response->type('application/vnd.android.package-archive');
        $this->set($params);
    }

    
    public function detail($id = null, $version = null) {
        $this->set('title_for_layout','Detalles');

        $options = array(
            'conditions'=>array('Application.name' => $id)
            );
        if(isset($version)){//es que quiero descargar una version en especifico
            $options['conditions']['Application.version'] = $version;
        }else{//es que quiero descargar la mas reciente
            $options['order']['Application.version'] = 'desc';
        }
        $apk = $this->Application->find('first',$options);
        if (!isset($apk['Application'])) {
            throw new NotFoundException(__('Invalid apk'));
        }            
        //buscar las aplicaciones relacionadas
        if($apk['Category']['id'] !== 1){
            $count = $this->Application->find('count', array('conditions' => array(
                    'Application.categories_id' => $apk['Category']['id'],
                    'Application.parent_id is null',
                    'Application.id != ' . "'" .$apk['Application']['id'] . "'"
                )));
            $result = rand(0,$count - 3);   
            //aqui cojo 6 aplicaciones que sean de la miama categoria
            $related = $this->Application->find('all', array(
                'conditions' => array(
                    'Application.categories_id' => $apk['Category']['id'],
                    'Application.parent_id is null',
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
