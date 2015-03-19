<?php
App::uses('AppController', 'Controller');
/**
 * Uploads Controller
 *
 * @property Upload $Upload
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class UploadsController extends AppController {

    var $uses = array(
        'Upload',
        'Configuration',
        'Category',
        'Application',
        'Version',
    );

/**
 * Components
 *
 * @var array
 */
    public $components = array('BdHelper', 'Paginator', 'Session');

public function isAuthorized($user) {
    $padre = parent::beforeFilter();
    if($padre){
        return true;
    }
    if (($user['role'] == 'uploader' || $user['role'] == 'manager' ) && $this->action == 'upload') {
        return true;
    }else if($user['role'] == 'admin') return true;
    return false;
}

    public function index() {
        $this->Upload->recursive = 0;
        $this->set('uploads', $this->Paginator->paginate());
    }

    public function view($id = null) {
        if (!$this->Upload->exists($id)) {
            throw new NotFoundException(__('Invalid upload'));
        }
        $options = array('conditions' => array('Upload.' . $this->Upload->primaryKey => $id));
        $this->set('upload', $this->Upload->find('first', $options));
    }

    public function update($id = null) {
        $bad_category = array('Terceros','Temporalmente nada', '');
        if (!$this->Upload->exists($id)) {
            throw new NotFoundException(__('Invalid upload'));
        }
        $ok = true;
        $strSource = $_SERVER['CONTEXT_DOCUMENT_ROOT'] .'poolUpload/';
        $strDest = $_SERVER['CONTEXT_DOCUMENT_ROOT'] .'pool/';
        //obtengo la tupla desde upload
        $options = array('conditions' => array('Upload.' . $this->Upload->primaryKey => $id));
        $up =  $this->Upload->find('first', $options);
        $strSource .= $up['Upload']['name'] . '/' . $up['Upload']['version'] . '/' . $up['Upload']['name'];//Falta la extencion

        //construyo la direccion destino
        if(!is_dir($strDest)){
             mkdir($strDest);
                chgrp($strDest, "www-data");
        }
        $strDest .= $up['Upload']['name'] . '/';
        if(!is_dir($strDest)){
            mkdir($strDest);
                chgrp($strDest, "www-data");
        }
        $strDest .= $up['Upload']['version'] . '/';
        if(!is_dir($strDest)){
            mkdir($strDest);
                chgrp($strDest, "www-data");
        }
        $strDest .= $up['Upload']['name'];
        if(!file_exists($strDest . '.apk')){
            //si no existe el fichero entonces hay que copiarlo
            $moveFail = false;
            if(!copy( $strSource . '.png', $strDest . '.png' ) ){
                $moveFail = true;
            }
            if(!copy( $strSource . '.apk', $strDest . '.apk' ) ){
                $moveFail = true;
            }
            //borro los ficheros
            unlink($strSource . '.apk');
            unlink($strSource . '.png');
            //borro las carpetas
            $strdel = $_SERVER['CONTEXT_DOCUMENT_ROOT'] .'poolUpload/';
            $folderVersion = $strdel . $up['Upload']['name'] . '/' . $up['Upload']['version'] . '/';
            rmdir($folderVersion);
            // $folderId = $strdel . $up['Upload']['name'] . '/';
            // rmdir($folderId);
            if(!$moveFail){
                
                //ver si este id esta ya en aplication
                //recoger el de aplicacion
                $options = array('conditions' => array('Application.' . $this->Application->primaryKey => $up['Upload']['name']));
                $app =  $this->Application->find('first', $options);
                //si el id esta en aplicacion es que ya hay una version en el sistema por lo que procedo
                //a ver los codigos, si no entonces la inserto en application
                if(!isset($app['Application']['id'])){//Si no esta en appplication la inserto
                    //preparo el array
                    $toINsert = array();
                    $toINsert['Application'] = array();
                    $toINsert['Application']['id'] = $up['Upload']['name'];
                    $toINsert['Application']['label'] = $up['Upload']['label'];
                    $toINsert['Application']['version'] = $up['Upload']['version'];
                    $toINsert['Application']['code'] = $up['Upload']['code'];
                    $toINsert['Application']['categories_id'] = $up['Upload']['categories_id'];
                    $toINsert['Application']['description'] = $up['Upload']['description'];//esto esta en prueba por ahora pasare null
                    $toINsert['Application']['sdkversion'] = $up['Upload']['sdkversion'];// esto esta en veremos
                    $toINsert['Application']['downloads'] = 0;
                    $toINsert['Application']['rating'] = 0;
                    $toINsert['Application']['size'] = $up['Upload']['size'];
                    $toINsert['Application']['developer'] = $up['Upload']['developer'];
                    $toINsert['Application']['have_data'] = 0;
                    //lo inserto en app sin problema alguna ya que no esta
                    $this->Application->create();
                    if ($this->Application->save($toINsert)) {
                        //luego de insertado lo elimino de upload
                        $this->Upload->id = $id;
                        if ($this->Upload->delete()) {
                            $this->BdHelper->setBDupdatable();
                            $this->Session->setFlash(__('La nueva aplicación ha sido agregada con éxito.'));
                        } else {
                            $ok = false;
                            $this->Session->setFlash(__('No se pudo eliminar el elemento de la tabla upload. Realice la eliminacion directamente.'));
                        }
                    }else{
                        $ok = false;
                        $this->Session->setFlash(__('La nueva aplicación no ha sido agregada.'));
                    }

                }else{//si esta en app, verifico los codigos y si es mayor actualizo sino voy para versiones
                    if($up['Upload']['version'] > $app['Application']['version']){
                        //si la version a insertar es mayor que la que esta, actualizo application con la nueva
                        //he inserto la de apliation en version, sin verificar nada ya que no deveria estar

                        //para poner en versiones
                        $toINsert = array();
                        $toINsert['Version'] = array();
                        $toINsert['Version']['application_id'] = $app['Application']['id'];
                        $toINsert['Version']['label'] = $app['Application']['label'];
                        $toINsert['Version']['version'] = $app['Application']['version'];
                        $toINsert['Version']['code'] = $app['Application']['code'];
                        $toINsert['Version']['categories_id'] = $app['Application']['categories_id'];
                        $toINsert['Version']['description'] = $app['Application']['description'];//esto esta en prueba por ahora pasare null
                        $toINsert['Version']['sdkversion'] = $app['Application']['sdkversion'];// esto esta en veremos
                        $toINsert['Version']['downloads'] = $app['Application']['downloads'];
                        $toINsert['Version']['rating'] = $app['Application']['rating'];
                        $toINsert['Version']['developer'] = $app['Upload']['developer'];
                        $toINsert['Version']['size'] = $app['Upload']['size'];
                        $toINsert['Version']['have_data'] = $app['Application']['have_data'];
                        $this->Version->create();
                        if ($this->Version->save($toINsert)) {
                            //si se inserto en versiones ok
                            $toINsert['Application'] = array();
                            $toINsert['Application']['id'] = $up['Upload']['name'];
                            $toINsert['Application']['label'] = $up['Upload']['label'];
                            $toINsert['Application']['version'] = $up['Upload']['version'];
                            $toINsert['Application']['code'] = $up['Upload']['code'];
                            $toINsert['Application']['categories_id'] = $up['Upload']['categories_id'];
                            $toINsert['Application']['description'] = $up['Upload']['description'];//esto esta en prueba por ahora pasare null
                            $toINsert['Application']['sdkversion'] = $up['Upload']['sdkversion'];// esto esta en veremos
                            $toINsert['Application']['downloads'] = 0;
                            $toINsert['Application']['rating'] = 0;
                            $toINsert['Application']['size'] = $app['Upload']['size'];
                            $toINsert['Application']['developer'] = $up['Upload']['developer'];
                            $toINsert['Application']['have_data'] = 0;
                            $this->Application->create();
                            if ($this->Application->save($toINsert)) {
                                //luego de insertado lo elimino de upload
                                $this->Upload->id = $id;
                                if ($this->Upload->delete()) {
                                    $this->BdHelper->setBDupdatable();
                                    $this->Session->setFlash(__('La nueva aplicación ha sido agregada con éxito.'));
                                } else {
                                    $ok = false;
                                    $this->Session->setFlash(__('No se pudo eliminar el elemento de la tabla upload. Realice la eliminacion directamente.'));
                                }
                            }else{
                                $ok = false;
                                $this->Session->setFlash(__('La nueva aplicación no ha sido agregada.'));
                            }
                        }else{
                            $ok = false;
                            $this->Session->setFlash(__('La nueva aplicación no ha sido agregada.'));
                        }


                    }else{
                        //Si la version a insertar es menor entonces directamente, veo si existe en version
                        // si no existe la tupla entonces la inserto, no deveria ocurrie el caso de que exista
                        // ya que entonces en teoria el user no podria haberla subido.

                        //verificar la existencia en versiones
                        $options = array('conditions' => array(
                            'Version.application_id' => $up['Upload']['name'],
                            'Version.version' => $up['Upload']['version']
                        ));
                        $ver =  $this->Version->find('first', $options);
                        if(!isset($ver['Application']['application_id'])){//si no esta que es lo que deveria pasar, entonces la inserto
                            $toINsert = array();
                            $toINsert['Version'] = array();
                            $toINsert['Version']['application_id'] = $up['Upload']['name'];
                            $toINsert['Version']['label'] = $up['Upload']['label'];
                            $toINsert['Version']['version'] = $up['Upload']['version'];
                            $toINsert['Version']['code'] = $up['Upload']['code'];
                            $toINsert['Version']['category'] = $up['Upload']['categories_id'];
                            $toINsert['Version']['description'] = $up['Upload']['description'];//esto esta en prueba por ahora pasare null
                            $toINsert['Version']['sdkversion'] = $up['Upload']['sdkversion'];// esto esta en veremos
                            $toINsert['Version']['downloads'] = 0;
                            $toINsert['Version']['rating'] = 0;
                            $toINsert['Version']['size'] = $app['Upload']['size'];
                            $toINsert['Application']['developer'] = $up['Upload']['developer'];
                            $toINsert['Version']['have_data'] = 0;
                            $this->Version->create();
                            if ($this->Version->save($toINsert)) {
                                //luego de insertado lo elimino de upload
                                $this->Upload->id = $id;
                                if ($this->Upload->delete()) {
                                    $this->BdHelper->setBDupdatable();
                                    $this->Session->setFlash(__('La nueva aplicación ha sido agregada con éxito.'));
                                } else {
                                    $ok = false;
                                    $this->Session->setFlash(__('No se pudo eliminar el elemento de la tabla upload. Realice la eliminacion directamente.'));
                                }
                            }else{
                                $ok = false;
                                $this->Session->setFlash(__('La nueva aplicación no ha sido agregada.'));
                            }
                        }
                    }                   
                }
            }else{
                //error al copiar loe elemntos
                $this->Session->setFlash(__('No ha podido ser copiada la aplicación a su carpeta destino, verifique y los permisos de escritura y vuelva a intentarlo.'));
            }

        }else{
            //si el apk ya esta es que este elemento no hay que moverlo,
            //se asume que todo esta ok por lo que solo se elimina el elemento de upload
            $ok = false;
            $this->Upload->id = $id;
            if ($this->Upload->delete()) {
                $this->Session->setFlash(__('La aplicación ya existia, se ha eliminado el registro.'));
            } else {
                $this->Session->setFlash(__('No se pudo eliminar el elemento de la tabla upload. Realice la eliminacion directamente.'));
            }
        }
        if($ok){
            //Actualizo la info de configuracion
            $this->BdHelper->setBDupdatable();
            $this->Session->setFlash(__('La nueva aplicación ha sido agregada con éxito.'));
        }
        return $this->redirect(array('action' => 'index'));
    }

    public function upload(){
        if ($this->request->is('post')) {
            $objFile = $_FILES["uploaded"];
            $name = basename( $objFile["name"] );
            $info = $this->apk_info($objFile["tmp_name"]);
            // var_dump($objFile["tmp_name"]);
            // var_dump($info);
            // die();
            //Comprobar su ese apk para esa version ya esta arriba, si lo esta entonces no se sube
            $upl = $this->Upload->find('first',array('conditions'=>array('Upload.name'=>$info['id'], 'Upload.code'=>$info['code'])));
            //Comprobar que tampoco esta ni en application ni en version
            $app = $this->Application->find('first',array('conditions'=>array('Application.id'=>$info['id'], 'Application.code'=>$info['code'])));
            $vers = $this->Version->find('first',array('conditions'=>array('Version.id'=>$info['id'], 'Version.code'=>$info['code'])));
            if(!empty($upl) || !empty($app) || !empty($vers)){
                $this->Session->setFlash("La aplicacion " . $name . " con la version " . $info["code"] . " ya esta disponible en el servidor. Gracias por compartir con SAS.");
            }else {
                if ($this->censuredApk($info)) {
                    $this->Session->setFlash("La aplicacion " . $name . " con la version " . $info["code"] . " contiene en su contenido palablas censuradas por el sistema.");
                } else {
                    $strPath = $_SERVER['CONTEXT_DOCUMENT_ROOT'] . DS . 'poolUpload' . DS;
                    if (!is_dir($strPath)) {
                        mkdir($strPath, 7777);
                    }
                    $strPath .= $info['id'] . DS;
                    //            var_dump($_SERVER);
                    if (!is_dir($strPath)) {
                        mkdir($strPath, 7777);
                    }
                    $strPath .= str_replace(',', '.', $info['version']) . DS;
                    //            var_dump($_SERVER);
                    if (!is_dir($strPath)) {
                        mkdir($strPath, 7777);
                    }
                    $strPath .= $info['id'] . '.apk';
                    //            $strPath = 'files/'  . $info['id'] . '.apk';

                    //Almacenar en la BD
                    $upload = array(
                        'Upload' => array(
                            'name' => $info['id'],
                            'label' => $info['label'],
                            'version' => $info['version'],
                            'code' => $info['code'],
                            'categories_id' => (empty($_POST['category']))?1: $_POST['category'] ,
                            'description' => (empty($_POST['description']))?"Sin definir": $_POST['description'],
                            'sdkversion' => $info['sdk'],
                            'icon' => $info['icon'],
                            'size' => $info['size'],
                            'have_data' => 0,
                            'ip' => $this->request->clientIp(),
                            'client' => "Webadmin",
                            'user_id' => $this->Auth->user()['id'],
                        )
                    );

                    if (move_uploaded_file($objFile["tmp_name"], $strPath)) {
                        if ($this->Upload->save($upload)) {
                            $this->apk_icon($info);
                            $this->Session->setFlash("Aplicacion agregada con exito.");
                        } else {
                            $this->Session->setFlash("No se pudo almacenar el fichero en la base de datos, escriba un comentario con esta situacion para que se realice el proceso de indexado manualmente por parte de los administradores");
                        }

                    } else {
                        $this->Session->setFlash("Ocurrio un error al almacenar el fichero");
                    }
                }
            }


        }else{
           // $this->Session->setFlash("Seleccione la aplicacion a subir");
        }
        // $query = 'SELECT DISTINCT Application.category
        //          FROM applications as Application';
        // $cats = $this->Application->query($query);
//        var_dump($cats[0]['Application']["category"]);
        $cats = $this->Category->find("all", array());
        $this->set("categories", $cats);

        
    }
    private function esWindow(){
        $cadenaparaWindow = "Win";
        if(!strstr($_SERVER["SERVER_SOFTWARE"], $cadenaparaWindow))
            return false;
        return true;
    }
    public $censuredWords = array('sex', 'picture pack');
    private function censuredApk($info){
        foreach($this->censuredWords as $badWord){
//            $pos1 = stripos($info['label'], $badWord);
//            $pos2 = sstripos($info['id'], $badWord);
            if(stripos($info['label'], $badWord) !== false)
                return true;
            if(stripos($info['id'], $badWord) !== false)
                return true;
        }
        return false;
    }
    private function apk_info($APK)
    {
        if($this->esWindow()) {
            $SIZE = filesize($APK);
            $SDK = exec('soft\\aapt dump --values badging ' . $APK . ' | soft\\grep ^sdkVersion: | soft\\cut -d' . '"' . '\'' . '" -f2 | soft\\head -1');
            $ID = exec('soft\\aapt dump --values badging ' . $APK . ' | soft\\grep ^package: | soft\\cut -d' . '"' . '\'' . '" -f2 | soft\\head -1');
            $LABEL = exec('soft\\aapt dump --values badging ' . $APK . ' | soft\\grep application-label | soft\\cut -d: -f2 | soft\\head -1 ');
            $LABEL = substr($LABEL, 1, strlen($LABEL) - 2);
            $VERSION = exec('soft\\aapt dump --values badging ' . $APK . ' | soft\\grep ^package: | soft\\cut -d' . '"' . '\'' . '" -f4 | soft\\head -1 ');
            $CODE = exec('soft\\aapt dump --values badging ' . $APK . ' | soft\\grep ^package: | soft\\cut -d' . '"' . '\'' . '" -f6 | soft\\head -1 ');
            $RES = exec('soft\\aapt dump --values badging ' . $APK . ' | soft\\grep ^application: | soft\\cut -d= -f3 | soft\\head -1');
            $RES = substr($RES, 1, strlen($RES) - 2);
            return array('id' => $ID, 'label' => $LABEL, 'version' => $VERSION, 'code' => $CODE, 'sdk' => $SDK, 'size' => $SIZE, 'icon' => $RES);
        }else{
            $SIZE = filesize($APK);
            //echo $_SERVER['CONTEXT_DOCUMENT_ROOT'] . '/soft/aapt';
//            $ALL = exec($_SERVER['CONTEXT_DOCUMENT_ROOT'] . '/soft/aapt dump --values badging ' . $APK );
//            echo $ALL;
            $SDK = exec($_SERVER['CONTEXT_DOCUMENT_ROOT'] . '/soft/aapt dump --values badging ' . $APK . ' | grep ^sdkVersion: | cut -d\\\' -f2 | head -1');
            $ID = exec($_SERVER['CONTEXT_DOCUMENT_ROOT'] . '/soft/aapt dump --values badging ' . $APK . ' | grep ^package: | cut -d\\\' -f2 | head -1');
            $LABEL = exec($_SERVER['CONTEXT_DOCUMENT_ROOT'] . '/soft/aapt dump --values badging ' . $APK . ' | grep application-label | cut -d: -f2 | head -1 | sed s/\\\'//g');
            $VERSION = exec($_SERVER['CONTEXT_DOCUMENT_ROOT'] . '/soft/aapt dump --values badging ' . $APK . ' | grep ^package: | cut -d\\\' -f4 | head -1 ');
            $CODE = exec($_SERVER['CONTEXT_DOCUMENT_ROOT'] . '/soft/aapt dump --values badging ' . $APK . ' | grep ^package: | cut -d\\\' -f6 | head -1 ');
            $RES = exec($_SERVER['CONTEXT_DOCUMENT_ROOT'] . '/soft/aapt dump --values badging ' . $APK . ' | grep ^application: | cut -d= -f3 | head -1 | sed s/\\\'//g');
            return array('id' => $ID, 'label' => $LABEL, 'version' => $VERSION, 'code' => $CODE, 'sdk' => $SDK, 'size' => $SIZE, 'icon' => $RES);
        }
    }

    function apk_icon($APK)
    {
        $strPath = $_SERVER['CONTEXT_DOCUMENT_ROOT'] .'poolUpload' . DS;
        if(!is_dir($strPath)){
            mkdir($strPath, 7777);
        }
        $strPath .= $APK['id'] . DS;
        if(!is_dir($strPath)){
            mkdir($strPath, 7777);
        }
        $strPath .= str_replace(',','.', $APK['version']) . DS;
        if(!is_dir($strPath)){
            mkdir($strPath, 7777);
        }
        $strPath .=  $APK['id'];// . '.png';
        if($this->esWindow()) {
            exec($_SERVER['CONTEXT_DOCUMENT_ROOT'] . 'soft\\unzip -p "' . $strPath . '.apk' . '" ' . $APK['icon'] . ' > ' . $strPath . '.png');
        }else{
            exec('unzip -p "' . $strPath . '.apk' . '" ' .  $APK['icon'] . ' > ' . $strPath . '.png');
        }
    }
/**
 * add method
 *
 * @return void
 */
    public function add() {
        if ($this->request->is('post')) {
            $this->Upload->create();
            if ($this->Upload->save($this->request->data)) {
                $this->Session->setFlash(__('The upload has been saved.'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The upload could not be saved. Please, try again.'));
            }
        }
        $users = $this->Upload->User->find('list');
        $this->set(compact('users'));
    }

    public function edit($id = null) {
        if (!$this->Upload->exists($id)) {
            throw new NotFoundException(__('Invalid upload'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if ($this->Upload->save($this->request->data)) {
                $this->Session->setFlash(__('The upload has been saved.'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The upload could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Upload.' . $this->Upload->primaryKey => $id));
            $this->request->data = $this->Upload->find('first', $options);
        }
        $users = $this->Upload->User->find('list');
        $this->set(compact('users'));
    }

    public function delete($id = null) {
        $this->Upload->id = $id;
        if (!$this->Upload->exists()) {
            throw new NotFoundException(__('Invalid upload'));
        }
        $this->request->allowMethod('post', 'delete');
        if ($this->Upload->delete()) {
            $this->Session->setFlash(__('The upload has been deleted.'));
        } else {
            $this->Session->setFlash(__('The upload could not be deleted. Please, try again.'));
        }
        return $this->redirect(array('action' => 'index'));
    }
}
