<?php
/**
 * Created by JetBrains PhpStorm.
 * User: chenry
 * Date: 3/01/15
 * Time: 12:09 AM
 * To change this template use File | Settings | File Templates.
 */
App::uses('Component','Controller');
class BdHelperComponent extends Component{
    var $uses = array(
        'Configuration'
    );

    /*
     * este metodo se encarga de especificar que la BD fue actualizada y se puede generar un nuevo sqllite
     */
    public function setBDupdatable(){
        $configModel = ClassRegistry::init('Configuration');
        $config = $configModel->find('first');
        $config['Configuration']['bd_update'] = 1;
//        $config['Configuration']['last_db_update'] = null;
        $configModel->save($config);
    }

    /*
     * Especifica que se acaba de crear un nuevo sqllite y por lo tanto no hay nada que agregar a un sqllite
     */
    public function setBDupdate(){
        $configModel = ClassRegistry::init('Configuration');
        $config = $configModel->find('first');
        $config['Configuration']['bd_update'] = 0;
        $config['Configuration']['last_db_update'] = date('Y-m-d H:i:s');
        $configModel->save($config);
    }

    /*
     * devuelve true si esta actualizada falso en caso contrario
     */
    public function isDBupdate(){
        $configModel = ClassRegistry::init('Configuration');
        $config = $configModel->find('first');
        return ($config['Configuration']['bd_update'] == 0);
    }
}