<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {

    public $uses = array('User', 'Application', 'Configuration');
    
   // var $helpers = array('AjaxMultiUpload.Upload');
    
    //Descomentar esta linea cuando se monte el proyecto en produccion
    //public $layout = 'production';

    public $components = array('Session',
        'Auth' => array(
            'authorize' => array('Controller'),
            'loginRedirect' => array('controller' => 'applications', 'action' => 'repo'),
            'logoutRedirect' => array('controller' => 'users','action' => 'login'),
            'authError' => 'No está autorizado a consultar esa página.'
            //'authenticate' => array('Form' => array('fields' => array('username' => 'email')))
        )
    );

    public function beforeFilter() {
//        if($this->Auth->user('role') != 'admin'){
//            $this->Session->setFlash('No esta autorizado a consultar esa pagina');
//            $this->redirect(array('controller' => 'application', 'action' => 'detail','addon.simplylock.theme.example'));
//            die();
//        }

        //algunas cosas de aca se tienen que validar en el metodo como es el caso del upload cuando este
        $this->Auth->allow(
            'logout');
//        if ($this->Session->check('Config.language')) {
//            Configure::write('Config.language', $this->Session->read('Config.language'));
//        }
//        else{
//            Configure::write('Config.language', 'esp');
//        }

        $this->set('logged_in',$this->Auth->loggedIn());
        $this->set('userAutenticated',$this->Auth->user());
        $this->set('isadmin',($this->Auth->user()['role'] == 'admin')?1:0);

        //data for menu
        //put data en la pagina
        $config = $this->Configuration->find('first', array('conditions' => array('Configuration.id'=> 1)));
        $dayToNew = $config['Configuration']['days_to_new'];
        $date = date_create('now');
        date_sub($date, date_interval_create_from_date_string($dayToNew . ' days'));
        $settings =array(
            'conditions' => array(
                'Application.created >= "' . $date->format('Y-m-d H:i:s') . '"' ,
                ));
        $cantNew = $this->Application->find('count', $settings);

        $settings1 =array(
            'conditions' => array(
                'Application.recommended ' => 1,
                ));
        $cantRecomended = $this->Application->find('count', $settings1);

        $settings1 =array(
            'conditions' => array(
                'Application.verificate ' => 1,
                ));
        $cantverificate = $this->Application->find('count', $settings1);

        
        $this->set('cantnews',$cantNew);
        $this->set('recommended',$cantRecomended);
        $this->set('verificate',$cantverificate);

        
    }

    public function isAuthorized($user) {
//        var_dump($user);
        if ($user['role'] == 'admin') {
//            echo 'true';
            return true;
        }
//        echo 'false';
        // Default deny
        return false;
    }
}
