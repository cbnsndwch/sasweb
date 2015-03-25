<?php
App::uses('AppController', 'Controller');
App::uses('SimplePasswordHasher', 'Controller/Component/Auth');
/**
 * Created by JetBrains PhpStorm.
 * User: chenry
 * Date: 21/12/14
 * Time: 02:59 AM
 * To change this template use File | Settings | File Templates.
 */

class DevicesController  extends AppController {

    var $uses = array(
        'Apk',
        'User',
        'History',
        'Generalcoment',
        'Configuration',
        'Upload',
        'Application',
        'Version',
        'Noticy',
    );

    public $censuredWords = array('sex', 'picture pack');

    public function beforeFilter() {
        //algunas cosas de aca se tienen que validar en el metodo como es el caso del upload cuando este
        $this->Auth->allow(
            'manager',
            'downloadApp'
        );

        //las palabras censuradas que se mantienen en la BD se agrupan aqui y se conforma el array de palabras censuradas
    }

    public function manager() {
        $this->layout = null;//"xml/default.ctp";
        $this->autoRender = false;
        $tag = $_POST['tag'];
        $response = array("tag" => $tag, "success" => 0, "error" => 0);
//        echo "qwertyuiop";

        switch($tag){
            case "checkonline":
                $this->checkonline($response);
                break;
            case "checkonlineUpload":
                //Aqui se puede devolver tambien la forma disponible de upload para que el apk suba la aplicacion
//                $this->checkUpload($response);
                $response["success"] = 1;
                echo json_encode( $response);
                die();
                break;
            case "setUpload":
                $this->setUpload($response);
                break;
            case "testretrofit":
                $apks = array();
//                    array("id" => "2"),
//                    array("id" => "4")
//                );

                $list = $this->Apk->find("all", array());
                foreach($list as $app){
                    array_push($apks,array(
                        'id' => $app['Application']['id'],
                        'label' => $app['Application']['label'],
                        'version' => $app['Application']['version'],
                        'code' => $app['Application']['code'],
                        'size' => $app['Application']['size'],
                        'category' => $app['Application']['category'],
                        'description' => $app['Application']['description'],
                        'sdkversion' => $app['Application']['sdkversion'],
                        'downloads' => $app['Application']['downloads'],
                        'rating' => $app['Application']['rating'],
                        'have_data' => $app['Application']['have_data'],
                        'news' => 0
                    ));
                }
                $response['apk'] = $apks;

                echo json_encode($response);
                break;
            case "updatedb":
                $this->updatedb($response);
                break;
            case "devicelogin":
                $this->loginUser($response);
                break;
            case "deviceregister":
                $this->registerUser($response);
                break;
            case "generalcoment":
                $this->generalComent($response);
                break;
//            case "checkNotices":
//                $this->checkNotice($response);
//                break;
            case "downloadNotices":
                $this->notice($response);
                break;
            case "uploadApk":
                $this->uploadApk($response);
                break;
//            case "getNew":
                //$this->generalComent($response);
//                break;
            default:
//                $Apks = $this->Apks->find('all');
//        var_dump($Apks);
//                $response["success"] = 1;
//                $response["Apks"] = $Apks;
                $response["error"] = 1;
                $response["error_msg"] = "Comando incorrecto.";
                echo json_encode( $response);
                break;
        }


    }

    public function checkonline($response){
        $response["success"] = 1;
        //Aqui podria devolver varias cosas a los dispositivos, como por ejemplo
        //podria devolver el hash de la base de datos de esta forma no habria que descargarla si coincide
        //se pasara la info del usuario en caso de estar autenticado y si ya no es usuario, se perderan el device los privilegios de serlo
        

        //pasar el hash de la BD
        $config = $this->Configuration->find('first',array());
        $response["db_hash"] = $config['Configuration']['bd_hash'];


        echo json_encode($response);

    }
//    public function checkNotice($response){
//        $conditions = array();
//        if(isset($fecha_update)){
//            $fecha_update = $_POST['fecha_update'];
//            $fecha = new \DateTime($fecha_update);
//            $conditions = array(
//                'Noticy.created > ' => $fecha->format('Y-m-d H:i:s')
//            );
//        }
//        $count = $this->Noticy->find('count', array(
//            'conditions' => $conditions
//        ));
//        if($count > 0){
//            $response["success"] = 1;
////            $response["fecha"] = $fecha;
//        }else{
//            $response["error"] = 1;
//            $response["error_msg"] = "No hay nuevas noticias.";
//        }
//        echo json_encode( $response);
//    }

    private function notice($response){
        $query = 'SELECT Noticy.id, Noticy.title, Noticy.body, Noticy.created, User.username
                 FROM noticies as Noticy
                 LEFT JOIN users as User ON (Noticy.user_id = User.id) ';

        //fecha de ultima actualizacion de ese dispositivo
        if(isset($fecha_update)){
            $fecha_update = $_POST['fecha_update'];
            $fecha = new \DateTime($fecha_update);
            $conditionDate = ' Noticy.created > \'' . $fecha->format('Y-m-d H:i:s') . '\' ';
            $query .= ' WHERE ' . $conditionDate;
        }

        $noticies = $this->Noticy->query($query);

//      si tiene valores los devuelvo junto con un sucess 1 si no mando un error pero eso no debe pasar al no ser que ocurra un error de verdad
//      Si se quiere descargar las noticias
        if(!empty($noticies)){
            $response["success"] = 1;
            $response["noticies"] = $noticies;
        }else{
            $response["error"] = 1;
            $response["error_msg"] = "No se pudo obtener las noticias.";
        }
        echo json_encode($response);
    }

    private function checkUpload($response){
        $client = $_POST['client'];
//        $client = $_['client'];
        $deviceid = $_POST['deviceid'];
        $userTag = $_POST['userTag'];

        $apkname = $_POST['apk_name'];
        $apkId = $_POST['apk_id'];
        $apkVersion = $_POST['apk_version'];

        $user = $this->User->find('first',array('conditions'=>array('User.hash'=>$userTag)));
        if(empty($user)){
            $response["error"] = 1;
            $response["error_msg"] = "Debe tener un usuario valido para subir aplicaciones.";
            echo json_encode( $response);
        }else{
            //Comprobar su ese apk para esa version ya esta arriba, si lo esta entonces no se sube
            $upl = $this->Upload->find('first',array('conditions'=>array('Upload.name'=>$apkId, 'Upload.version'=>$apkVersion)));
            //Comprobar que tampoco esta ni en application ni en version
            $app = $this->Application->find('first',array('conditions'=>array('Application.id'=>$apkId, 'Application.version'=>$apkVersion)));
            $vers = $this->Version->find('first',array('conditions'=>array('Version.id'=>$apkId, 'Version.version'=>$apkVersion)));
            if(!empty($upl) || !empty($app) || !empty($vers)){
                $response["error"] = 1;
                $response["error_msg"] = "La aplicacion " . $apkname . " con la version " . $apkVersion . " ya esta disponible en el servidor. Gracias por compartir con SAS.";
            }else{
                //Checkear los nombre de las aplicaciones
                $info = array('label' =>  $apkname,'id' =>$apkId);
                if($this->censuredApk($info)){
                    $response["error"] = 1;
                    $response["error_msg"] = "La aplicacion " . $apkname . " contiene palablas censuradas por el sistema.";
                }else{
                    $response["success"] = 1;
                }
            }
        }

        echo json_encode($response);
    }

    private function setUpload($respose){

        $client = $_POST['client'];
        $deviceid = $_POST['deviceid'];
        $userTag = $_POST['userTag'];

        $apkname = $_POST['apk_name'];
        $apkId = $_POST['apk_id'];
        $apkcode = $_POST['apk_code'];
        $apksdkversion = $_POST['apk_sdk'];
        $apkVersion = $_POST['apk_version'];
        $apksize = $_POST['apk_size'];

        //FutureUse
        $apkHaveData = $_POST['apk_data'];
        $apkDescription = $_POST['apk_description'];
        $apkcategory = $_POST['apk_category'];

//        $info = array('label' =>  $apkname,'id' =>$apkId, 'version' => $apkVersion, 'icon' => '');

        $user = $this->User->find('first',array('conditions'=>array('User.hash'=>$userTag)));
        if(empty($user)){
            $response["error"] = 1;
            $response["error_msg"] = "El usuario autenticado no es valido.";
            echo json_encode( $response);
        }else{
            $strPath = $_SERVER['CONTEXT_DOCUMENT_ROOT'] . DS . 'poolUpload'. DS . $apkId . DS . $apkVersion. DS . $apkId;
            if(file_exists($strPath . '.apk')){

                $info = $this->apk_info($strPath . '.apk');

                $upload = array(
                    'Upload' => array(
                        'name' =>  $apkId,
                        'label' =>  $apkname,
                        'version' =>  $apkVersion,
                        'code' =>  $apkcode,
                        'category' =>  $apkcategory,
                        'description' =>   $apkDescription,
                        'sdkversion' =>  $apksdkversion,
                        'icon' =>  '',
                        'size' =>  $apksize,
                        'have_data' =>  $apkHaveData,
                        'ip' =>  $this->request->clientIp(),
                        'client' =>  $client,
                        'user_id' =>  $user['User']['id'],
                    )
                );
                $this->apk_icon($info);
                if($this->Upload->save($upload)){
                    $this->apk_icon($info);
                    $response["success"] = 1;
                    $response["info"] = $info;
                }else{
                    $response["error"] = 1;
                    $response["error_msg"] = "No se pudo almacenar el fichero en la base de datos, escriba un comentario con esta situación para que se realice el proceso de indexado manualmente por parte de los administradores.";
                }
            }else{
                $response["error"] = 1;
                $response["error_msg"] = "La aplicación no fue subida correctamente, verifique su conexión.";


            }

        }
        echo json_encode( $response);

    }

    private function uploadApk($response){
        //Aqui se recogera y almacenara los comentarios
//        $this->layout = null;
//        $this->viewClass = null;
//        $this->autoRender = false;

        $client = $_POST['client'];
        $deviceid = $_POST['deviceid'];
        $userTag = $_POST['userTag'];


        //Error enviado hasta que se resuelva el problema con el aapt en linux
//        $response["error"] = 1;
//        $response["error_msg"] = "No se puede subir aplicaciones por el momento.";
//        echo json_encode( $response);
//        die();

        $user = $this->User->find('first',array('conditions'=>array('User.hash'=>$userTag)));
        if(empty($user)){
            $response["error"] = 1;
            $response["error_msg"] = "El usuario autenticado no es valido";
            echo json_encode( $response);
        }else{
            $objFile = $_FILES["uploaded"];
            $name = basename( $objFile["name"] );
            $info = $this->apk_info($objFile["tmp_name"]);

            //Comprobar su ese apk para esa version ya esta arriba, si lo esta entonces no se sube
            $upl = $this->Upload->find('first',array('conditions'=>array('Upload.name'=>$info['id'], 'Upload.code'=>$info['code'])));
            //Comprobar que tampoco esta ni en application ni en version
            $app = $this->Application->find('first',array('conditions'=>array('Application.id'=>$info['id'], 'Application.code'=>$info['code'])));
            $vers = $this->Version->find('first',array('conditions'=>array('Version.id'=>$info['id'], 'Version.code'=>$info['code'])));
            if(!empty($upl) || !empty($app) || !empty($vers)){
                $response["error"] = 1;
                $response["error_msg"] = "La aplicacion " . $name . " con la version " . $info["code"] . " ya esta disponible en el servidor. Gracias por compartir con SAS.";
            }else{
                //Checkear los nombre de las aplicaciones
                if($this->censuredApk($info)){
                    $response["error"] = 1;
                    $response["error_msg"] = "La aplicacion " . $name . " con la version " . $info["code"] . " contiene en su contenido palablas censuradas por el sistema.";
                }else{
                    $strPath = $_SERVER['CONTEXT_DOCUMENT_ROOT'] .DS .'poolUpload' . DS;
                    if(!is_dir($strPath)){
                        mkdir($strPath, 7777);
                    }
                    $strPath .= $info['id'] . DS;
                    //            var_dump($_SERVER);
                    if(!is_dir($strPath)){
                        mkdir($strPath, 7777);
                    }
                    $strPath .= str_replace(',','.', $info['version']) . DS;
                    //            var_dump($_SERVER);
                    if(!is_dir($strPath)){
                        mkdir($strPath, 7777);
                    }
                    $strPath .=  $info['id'] . '.apk';
                    //            $strPath = 'files/'  . $info['id'] . '.apk';

                    //Almacenar en la BD
                    $upload = array(
                        'Upload' => array(
                            'name' =>  $info['id'],
                            'label' =>  $info['label'],
                            'version' =>  $info['version'],
                            'code' =>  $info['code'],
                            'category' =>  'Temporalmente nada',
                            'description' =>   'Temporalmente nada',
                            'sdkversion' =>  $info['sdk'],
                            'icon' =>  $info['icon'],
                            'size' =>  $info['size'],
                            'have_data' =>  0,
                            'ip' =>  $this->request->clientIp(),
                            'client' =>  $client,
                            'user_id' =>  $user['User']['id'],
                        )
                    );

                    if(move_uploaded_file( $objFile["tmp_name"], $strPath ) ){
                        if($this->Upload->save($upload)){
                            $this->apk_icon($info);
                            $response["success"] = 1;
                            $response["info"] = $info;
                        }else{
                            $response["error"] = 1;
                            $response["error_msg"] = "No se pudo almacenar el fichero en la base de datos, escriba un comentario con esta situacion para que se realice el proceso de indexado manualmente por parte de los administradores";
                        }

                    }else{
                        $response["error"] = 1;
                        $response["error_msg"] = "Ocurrio un error al almacenar el fichero";
                    }
                }
            }
        }

        echo json_encode( $response);
    }

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

    private function esWindow(){
        $cadenaparaWindow = "Win";
        if(!strstr($_SERVER["SERVER_SOFTWARE"], $cadenaparaWindow))
            return false;
        return true;
    }

    public function index(){

        var_dump($this->apk_info($_SERVER['CONTEXT_DOCUMENT_ROOT'] . "/pool/com.kiloo.subwaysurf/28/com.kiloo.subwaysurf.apk"));
//        var_dump($this->apk_info($_SERVER['CONTEXT_DOCUMENT_ROOT'] . "/pool/air.com.blissive.naturasoundtherapy/4000005/air.com.blissive.naturasoundtherapy.apk"));
        die();
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

    private function generalComent($response)
    {
        $client = $_POST['client'];
        $deviceid = $_POST['deviceid'];
        $comment = $_POST['comment'];
        $email = $_POST['email'];
        if(isset($_POST['userTag'])){
            $userTag = $_POST['userTag'];
            $comentsData = array('Generalcoment' => array(
                'coment' =>  $comment,
                'ip' => $this->request->clientIp(),
                'email' => $email,
                'client' => $client,
                'usertag' => $userTag
            ));
        }else{
            $comentsData = array('Generalcoment' => array(
                'coment' =>  $comment,
                'ip' => $this->request->clientIp(),
                'email' => $email,
                'client' => $client
            ));
        }

        if($this->Generalcoment->save($comentsData)){
            $response["success"] = 1;
            $response["comment"] = $comentsData;
        }else{
            $response["error"] = 1;
            $response["error_msg"] = "Ocurrio un error al almacenar el comentario";
        }
        echo json_encode( $response);
    }

    private function loginUser($response){
        $client = $_POST['client'];
        $deviceid = $_POST['deviceid'];
        $username = $_POST['username'];
        $pass = $_POST['password'];

        $passwordHasher = new SimplePasswordHasher();
        $pass1 = $passwordHasher->hash($pass);

        $user = $this->User->find('first', array(
            'conditions' => array(
                'User.username' => $username,
                'User.password' => $pass1
            )
        ));
//        echo json_encode( $user);
//        die();
        if(!empty($user)){
            $response["success"] = 1;
            $response["user"] = $user;
        }else{
            $response["error"] = 1;
            $response["error_msg"] = "Usuario o clave incorrecto!";
        }
        echo json_encode( $response);
    }

    private function registerUser($response){
        $client = $_POST['client'];
        $deviceid = $_POST['deviceid'];
        $username = $_POST['username'];
        $pass = $_POST['password'];

        $passwordHasher = new SimplePasswordHasher();
        $pass1 = $passwordHasher->hash($username . $pass);
        //Comprobar que el nombre de usuario sea unico
        $options = array('conditions' => array('User.username' => $username));
        $test = $this->User->find('first', $options);
//        var_dump($test);
//        die();
        if(isset($test['User'])){
            $response["error"] = 1;
            $response["error_msg"] = "Nombre de usuario existente!";
        }else
        {

    //        validacion de unico y esas cosas para el user
            //es importante validar esas cosas antes de sacar el modulo de registro
            $user = array('User' => array(
                'username' =>  $username,
                'password' => $pass,
                'role' => 'author',
                'hash' => $pass1
            ));
            if($this->User->save($user)){
                $response["success"] = 1;
                $response["user"] = $user;
            }else{
                $response["error"] = 1;
                $response["error_msg"] = "Usuario o clave incorrecto!";
            }
        }
        echo json_encode( $response);
    }

    private function updatedb($response){
        $client = $_POST['client'];
        if(isset($_POST['userTag']))
            $userTag = $_POST['userTag'];
        if(isset($_POST['fecha_update']))
            $fecha_update = $_POST['fecha_update'];

//        if($fecha_update == ""){

        $response["success"] = 1;
        $response["download"] = true;
        $response["file"] = "index.db";//Aqui especifico el nombre del fichero a descargar para si luego
        //quiero que se descargue un fichero determinado y no simpre el mismo
        echo json_encode( $response);
//        }else{
//
//
//            echo json_encode( $response);
//        }

    }

    public function downloadApp($id = null){
        $last = substr($id, strlen($id) - 4);
        if($last === ".apk"){
            $id = substr($id, 0,  strlen($id) - 4);
        }
        if (!$this->Apk->exists($id)) {
            throw new NotFoundException(__('Invalid apk'));
        }

        $label = $id;
        $this->layout = null;
        $this->viewClass = 'Media';
        $file = $this->Apk->find('first',array('conditions'=>array('Apk.id'=>$id)));
        $down = $file['Apk']['downloads'] + 1;
        //Salvar el apk con el aumento de el campo downloads para indicar que hubo un cambio mas
        $this->Apk->id = $id;
        $this->Apk->saveField('downloads', $down);
        if ($this->Application->exists($id)) {
            $this->Application->id = $id;
            $this->Application->saveField('downloads', $down);
        }
        //$data1 = $this->request->header('EXTRA_INFO');
        if(isset($this->request->data['client']))
            $client = $this->request->data['client'];
        else{
            $client = '';
            throw new NotFoundException(__('App client obsolete'));
            //echo "error";
            //die();
        }
        $dataHistory = array('History' => array(
            'name' =>  $file['Apk']['id'],
            'ip' => $this->request->clientIp(),
            'client' => $client
        ));
        $this->History->save($dataHistory);
        $label = $file['Apk']['label'];
        $params = array(
            'id'        => '',
            'name'      => $label ,
            'extension' => 'apk',
            'mimeType'  => 'application/vnd.android.package-archive',
            'path'  =>   'webroot' . DS . 'pool' . DS . $id . DS . $file['Apk']['version'] . DS . $id  .'.apk',
            'download'=>true
        );
        $this->response->type('application/vnd.android.package-archive');
        $this->set($params);
    }

}