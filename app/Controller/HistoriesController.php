<?php
App::uses('AppController', 'Controller');
/**
 * Histories Controller
 *
 * @property History $History
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class HistoriesController extends AppController {

var $uses = array(
        'History',
        'Network',
    );

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
	 public function beforeFilter(){
        parent::beforeFilter();

        $this->Paginator->settings=array(
            'limit'=>15,
           
        );
    }

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->History->recursive = 0;

		$hist = $this->Paginator->paginate();
		// for ($i = 0; $i < count($hist); $i++) {
		// 	$hist[$i]['History']['area'] = $this->getNetwork($hist[$i]['History']['ip']);
		// }
		// var_dump($hist[0]);
		$this->set('histories', $hist);
	}

	public function distribution() {
		$this->History->recursive = 0;


		// $data = $this->Network->find('all', array());
		// for ($i = 0; $i < count($data); $i++) {
		// 	$rango = $data[$i]['Network']['area'] . '.0/24';
		// 	$data[$i]['Network']['area'] = $data[$i]['Network']['rango'] ;
		// 	$data[$i]['Network']['rango'] = $rango;
		// 	$this->Network->save($data[$i]);
		// }


		$hist = $this->Paginator->paginate();
		$networks = $this->Network->find('all', array());
		for ($i = 0; $i < count($hist); $i++) {

			$hist[$i]['History']['area'] = $this->getNetwork($networks, $hist[$i]['History']['ip']);
		}
		// var_dump($hist[0]);
		$this->set('histories', $hist);
	}

	private function getNetwork($networks, $ip){
		foreach ($networks as $n) {
			if($this->ip_pertenece_a_red($ip, $n['Network']['rango'])){
				return $n['Network']['area'];
			}
		}
		return $ip;
	}
	/** 
	* Devuelve TRUE si la dirección IPv4 dada pertenece a la subred indicada, FALSE si no 
	* 
	* @param string $str_ip Dirección IP en formato '127.0.0.1' 
	* @param string $str_rango Red y máscara en formato '127.0.0.0/8', '127.0.0.0/255.0.0.0' o '127.0.0.1' 
	* @return bool * * @version v2011-08-30 */ 
	private function ip_pertenece_a_red($str_ip, $str_rango){     
		// Extraemos la máscara     
		list($str_red, $str_mascara) = array_pad(explode('/', $str_rango), 2, NULL);     
		if( is_null($str_mascara) ){         
			// No se especifica máscara: el rango es una única IP         
			$mascara = 0xFFFFFFFF;     
		}elseif( (int)$str_mascara==$str_mascara ){         
			// La máscara es un entero: es un número de bits         
			$mascara = 0xFFFFFFFF << (32 - (int)$str_mascara);     
		}else{         
			// La máscara está en formato x.x.x.x        
			 $mascara = ip2long($str_mascara);     
		}     
		$ip = ip2long($str_ip);     
		$red = ip2long($str_red);     
		$inf = $red & $mascara;     
		$sup = $red | (~$mascara & 0xFFFFFFFF);     
		return $ip>=$inf && $ip<=$sup; 
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->History->exists($id)) {
			throw new NotFoundException(__('Invalid history'));
		}
		$options = array('conditions' => array('History.' . $this->History->primaryKey => $id));
		$this->set('history', $this->History->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->History->create();
			if ($this->History->save($this->request->data)) {
				$this->Session->setFlash(__('The history has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The history could not be saved. Please, try again.'));
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
		if (!$this->History->exists($id)) {
			throw new NotFoundException(__('Invalid history'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->History->save($this->request->data)) {
				$this->Session->setFlash(__('The history has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The history could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('History.' . $this->History->primaryKey => $id));
			$this->request->data = $this->History->find('first', $options);
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
		$this->History->id = $id;
		if (!$this->History->exists()) {
			throw new NotFoundException(__('Invalid history'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->History->delete()) {
			$this->Session->setFlash(__('The history has been deleted.'));
		} else {
			$this->Session->setFlash(__('The history could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
