<?php
/**
 * Created by JetBrains PhpStorm.
 * User: chenry
 * Date: 3/01/15
 * Time: 04:12 AM
 * To change this template use File | Settings | File Templates.
 */

/* 
 * Esta clase se encargara de la generacion o actualizacion de la BD a partir de una carpeta del servidor,
 * esta carpeta sera pasada por parametro a la funcion llamada
 * estara construido para estar encapsulados todos los procesos, por lo que lo primero que se creara
 * es la BD y se popularan los ficheros en el server, una vez esto este realizado
 * abra metodos para, upgradrar la informacion de categoria y descripcion segun patron
 * y cada uno de los procesos descritos en el script
 */
class GenerateShell  extends AppShell{
    var $uses = array(
        'Apk',
        'Configuration',
        'Category',
        'Upload',
        'Application',
        'Noticy',
        'Version',
    );

    public $censuredWords = array('sex', 'Picture Pack');

    public function main() {
        $this->out("=========================================================================");
        $this->out(" HERRAMIENTA PARA LA ADMINISTRACION LOCAL DEL SISTEMA SASWEB");
        $this->out();
        $this->out(" USO:");
        $this->out(" Actualiza la Base de datos con las aplicaciones contenidas en 'dir':");
        $this->out("  ~$ cake generate scandir <directorio de apks>");
        $this->out(" Actualiza la informacion de la Base de datos usando como fuente la ");
        $this->out(" pagina de google play:");
        $this->out("  ~$ cake generate update");
        $this->out(" Actualiza la informacion de las versiones Base de datos usando como ");
        $this->out(" fuente la pagina de google play:");
        $this->out("  ~$ cake generate update_version");
        $this->out();
        $this->out();
        $this->out(" Uso a travez de Proxy:");
        $this->out("  ~$ cake generate update <usuario>:<contraseña>@<servidor>:<puerto>");
        $this->out("=========================================================================");

//        $this->out('Aqui tengo que poner el usage que indica como usar este shell, importante si alguien mas va a administrar el sitio');
    }

    public function test(){
//        $data = $_SERVER['argv'][2];
//        $root = substr($data,0, strlen($data) -1 ) . '\\webroot\\poolUpload\\com.joeykrim.rootcheckp\\1.2.1\\com.joeykrim.rootcheckp';
//        $root = substr($data,0, strlen($data) -1 ) . '\\webroot\\pool\\';
//       var_dump($root);
//        var_dump($this->apk_info($root));
//        $root = $this->getBasePath() . 'webroot\\pool\\com.aimp.player\\125\\com.aimp.player';
//        $test = $this->apk_info($root . '.apk');
//        $this->apk_icon('', '');

//        var_dump($this->get_filesInt($root));
//        $filename = 'qwe rty';
//        $filename = str_replace(' ', '\ ', $filename);
//        var_dump($filename);
        var_dump($this->Application->find('all', array('limit' => 1, )));
    }

    public function dtest(){
        var_dump($this->get_contenido("addon.simplylock.theme.example",  "acid-dsi:pass@10.8.6.38:3128"));
    }

    public function cleanLabelEmpty(){
        $root = $this->getBasePath() . 'webroot\\pool\\';
        $options = array('conditions' => array('Application.label' => ''));
        $apps =  $this->Application->find('all', $options);
        $this->out(count($apps) . ' aplicaciones a eliminar.');
        foreach($apps as $app){
            $this->Application->id =  $app['Application']['id'];
            if ($this->Application->exists()) {
                if ($this->Application->delete()) {
                    $temp = $root . $app['Application']['id'] . '\\' . $app['Application']['version'] . '\\' . $app['Application']['id'] ;
                    //Elimino el apk
                    unlink($temp . '.apk');
                    unlink($temp . '.png');
                    $temp = $root . $app['Application']['id'] . '\\' . $app['Application']['version'];
                    if(is_dir($temp))
                        rmdir($temp);
                    $temp = $root . $app['Application']['id']. '\\';
                    if(is_dir($temp))
                        rmdir($temp);
                    $this->out('Eliminada ' . $app['Application']['id'] . ' por no tener un nombre.');
                }
            }
        }

        $options = array('conditions' => array('Version.label' => ''));
        $apps =  $this->Version->find('all', $options);
        $this->out(count($apps) . ' versiones a eliminar.');
        foreach($apps as $app){
            $this->Version->id =  $app['Version']['id'];
            if ($this->Version->exists()) {
                if ($this->Version->delete()) {
                    $temp = $root . $app['Version']['application_id'] . '\\' . $app['Version']['version'] . '\\' . $app['Version']['application_id'] ;
                    //Elimino el apk
                    unlink($temp . '.apk');
                    unlink($temp . '.png');
                    $temp = $root . $app['Version']['application_id'] . '\\' . $app['Version']['version'];
                    if(is_dir($temp))
                        rmdir($temp);
                    $temp = $root . $app['Version']['application_id']. '\\';
                    if(is_dir($temp))
                        rmdir($temp);
                    $this->out('Eliminada ' . $app['Version']['application_id'] . ' por no tener un nombre.');
                }
            }
        }
    }

    public function scandir(){

        if(isset($this->args[0])){
            //recojo el directorio a scanear
            $dirToScan = $this->args[0];
            //busco los apks en ese directorio
            $files = $this->get_files($dirToScan);
            foreach ($files as $file) {
                $info = $this->apk_info($file);                
                if($info['id'] == "" || $info['label'] == "" || $info['version'] == ""){
                    continue;
                }
                //Censurar por nombres las aplicacicones
                if($this->censuredApk($info)){
                    $this->out($info['label'] . ' fue censurada.');
                    continue;
                }

                $options = array('conditions' => array('Upload.name' => $info['id'], 'Upload.version' => $info['version']));
                $app =  $this->Upload->find('first', $options);
                if(!isset($app['Upload']['id'])){
                    $toINsert = array(
                        'Upload' => array(
                            'name' => $info['id'],
                            'label' => $info['label'],
                            'version' =>$info['version'],
                            'code' => $info['code'],
                            'size' => $info['size'],
                            'verificate' => 0,
                            'user_id' => 1,
                            'sdkversion' =>$info['sdk'],
                            'have_data' => 0
                        )
                    );
                    //lo inserto en app sin problema alguna ya que no esta
                    $this->Upload->create();
                    if ($this->Upload->save($toINsert)) {
                        $this->copy_to_poolUpload($file, $info);
                        $this->out($info['label'] . ' Fue agregada con exito a la tabla Upload.');
                    }
                }
            }
            //marco la BD como modificada
            // $config = $this->Configuration->find('first', array('conditions' => array('Configuration.id'=> 1)));
            // $config['Configuration']['bd_update'] = 1;
            // $this->Configuration->save($config);
        }else{
            $this->out('Debe especificar el directorio a escanear');
        }
    }

    public function update_applications(){
        $bad_category = array('Terceros','Temporalmente nada', '');
        $proxy = null;
        if(isset($this->args[0])){
            $proxy = $this->args[0];
        }

        $options = array(
            'conditions' => array(
                'OR' => array(
                    'Application.categories_id' => 1
                )
            )
        );
        //Aplicaciones a actualizar
        $apps =  $this->Application->find('all', $options);
        $this->out(count($apps) . ' aplicaciones a verificar en googleplay');
        $i = 0;
        foreach($apps as $app){
            $info = $this->get_contenido($app['Application']['id'], $proxy);         
            if($info['category'] === "")
                continue;   
            // var_dump($info);die();
            //verificar qeu la categoria existe
            $noesta = $this->Category->find('first', array('conditions'=>array('Category.name' => $info['category'])));
            $cat_id = 1;
            if (!isset($noesta['Category'])) {       
                //verifico que no sea una de las palabras qeu no puede ir
                if(!in_array($info['category'], $bad_category)){                       
                    //sino es una mala palabra la inserto
                    $toINsert = array(
                        'Category' => array(
                            'name' => $info['category']
                        )
                    );
                    //lo inserto en app sin problema alguna ya que no esta
                    $this->Category->create();
                    $cat_id = $this->Category->id;
                    if ($this->Category->save($toINsert)) {                        
                        $this->out($app['Application']['category'] . ' Fue agregada con exito a la tabla Categorias.');
                    }
                }else{
                    $cat_id = 1;
                }
            }else{
                $cat_id = $noesta['Category']['id'];
            }            
            //si es distinto se actualiza la informacion
            $app['Application']['categories_id'] = $cat_id;
            $app['Application']['description'] = $info['description'];
            $app['Application']['developer'] = $info['devel'];             
            if($this->Application->save($app)){
                $this->out("La aplicacion " . $app['Application']['label'] . ' se coloco en la categoría ' . '"' . $info['category'] . '"');
                $i ++;
            }
            
        }
        $this->out($i . ' aplicaciones a actualizadas en googleplay');
    }

    public function update_version(){
        $bad_category = array('Terceros','Temporalmente nada', '');
        $proxy = null;
        if(isset($this->args[0])){
            $proxy = $this->args[0];
        }

        $options = array(
            'conditions' => array(
                'OR' => array(
                    'Version.categories_id' => 1
                )
            )
        );
        //Aplicaciones a actualizar
        $apps =  $this->Version->find('all', $options);
        $this->out(count($apps) . ' aplicaciones a verificar en googleplay');
        $i = 0;
        foreach($apps as $app){
            $info = $this->get_contenido($app['Version']['application_id'], $proxy);   
            if($info['category'] === "")
                continue;   
            // var_dump($info);die();
            //verificar qeu la categoria existe
            $noesta = $this->Category->find('first', array('conditions'=>array('Category.name' => $info['category'])));
            $cat_id = 1;
            if (!isset($noesta['Category'])) {                 
                //verifico que no sea una de las palabras qeu no puede ir
                if(!in_array($info['category'], $bad_category)){                       
                    //sino es una mala palabra la inserto
                    $toINsert = array(
                        'Category' => array(
                            'name' => $info['category']
                        )
                    );
                    //lo inserto en app sin problema alguna ya que no esta
                    $this->Category->create();
                    $cat_id = $this->Category->id;
                    if ($this->Category->save($toINsert)) {                        
                        $this->out($app['Version']['category'] . ' Fue agregada con exito a la tabla Categorias.');
                    }
                }else{
                    $cat_id = 1;
                }
            }else{
                $cat_id = $noesta['Category']['id'];
            }            
            //si es distinto se actualiza la informacion
            $app['Version']['categories_id'] = $cat_id;
            $app['Version']['description'] = $info['description'];
            $app['Version']['developer'] = $info['devel'];             
            if($this->Version->save($app)){
                $this->out("La aplicacion " . $app['Version']['label'] . ' se coloco en la categoría ' . '"' . $info['category'] . '"');
                $i ++;
            }
            
        }
        $this->out($i . ' aplicaciones a actualizadas en googleplay');
    }

    public function update_uploads(){
        $bad_category = array('Terceros','Temporalmente nada', '');
        $proxy = null;
        if(isset($this->args[0])){
            $proxy = $this->args[0];
        }

        $options = array(
            'conditions' => array(
                'OR' => array(
                    'Upload.categories_id' => 1
                )
            )
        );
        //Aplicaciones a actualizar
        $apps =  $this->Upload->find('all', $options);
        $this->out(count($apps) . ' aplicaciones a verificar en googleplay');
        $i = 0;
        foreach($apps as $app){
            $info = $this->get_contenido($app['Upload']['name'], $proxy);   
            if($info['category'] === "")
                continue;   
            // var_dump($info);die();
            //verificar qeu la categoria existe
            $noesta = $this->Category->find('first', array('conditions'=>array('Category.name' => $info['category'])));
            $cat_id = 1;
            if (!isset($noesta['Category'])) {               
                //verifico que no sea una de las palabras qeu no puede ir
                if(!in_array($info['category'], $bad_category)){                       
                    //sino es una mala palabra la inserto
                    $toINsert = array(
                        'Category' => array(
                            'name' => $info['category']
                        )
                    );
                    //lo inserto en app sin problema alguna ya que no esta
                    $this->Category->create();
                    $cat_id = $this->Category->id;
                    if ($this->Category->save($toINsert)) {                        
                        $this->out($info['category'] . ' Fue agregada con exito a la tabla Categorias.');
                    }else{
                        $cat_id = 1;    
                    }
                }else{
                    $cat_id = 1;
                }
            }else{
                $cat_id = $noesta['Category']['id'];
            }            
            //si es distinto se actualiza la informacion
            $app['Upload']['categories_id'] = $cat_id;
            $app['Upload']['description'] = $info['description'];
            $app['Upload']['developer'] = $info['devel'];             
            if($this->Upload->save($app)){
                $this->out("La aplicacion " . $app['Upload']['label'] . ' se coloco en la categoría ' . '"' . $info['category'] . '"');
                $i ++;
            }
            
        }
        $this->out($i . ' aplicaciones a actualizadas en googleplay');
    }

    public function ready(){
       $root = $this->getBasePath();
        $source = $root . 'toupdate.db';
        $destiny = $root . DS . 'webroot' . DS . 'index.db';        
        //eliminar update
        if(file_exists($source))
            unlink($source);
        //crear toupdate nuevamente con los valores necesarios
        try {
            $db = new PDO('sqlite:' . $source);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
            $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            $db->exec("create table apks (id TEXT UNIQUE PRIMARY KEY, label TEXT, version TEXT, code TEXT, description TEXT, category TEXT, sdkversion TEXT, size INT, downloads INT, have_data INT, verificate  INT, recommended INT, only_logged INT, uploader TEXT, have_version TEXT, created TEXT)");
            $db = null;
        } catch (PDOException $e) {
            echo 'Connexion impossible';
        }

        //solicito la configuracion para ver la ultima fecha de actualizacion
        $config = $this->Configuration->find('first', array('conditions' => array('Configuration.id'=> 1)));

        if($config['Configuration']['bd_update'] ==0){
            $this->out('La Base de Datos esta actualizada.');
            die();
        }

        $this->out('Eliminando los registros actuales.');
        //Eliminar la BD temporal
        $this->Apk->useDbConfig = 'temp';
        $licenses = $this->Apk->query(
            'delete from apks'
        );
        $this->out('Eliminado finalizado.');
        //recojo todas las aplicaciones en el sistema que son anteriores a la ultima fecha de actualizacion
        //si es null la fecha entonces todas son nuevas
        $i =0;
        $j =0;
        //if(isset($config['Configuration']['last_db_update'])){
            //si no es null lo pido separado
            //aqui dentro del if pido los viejos y preparo la query para los nuevos
            //Primero los viejos
            $fecha_update = $config['Configuration']['last_db_update'];
            $fecha = new \DateTime($fecha_update);
            $conditionDate = array(/*' Application.created < ' =>  $fecha->format('Y-m-d H:i:s')*/);
            $old = $this->Application->find('all', array(/*'limit' => 100,*/ 'conditions' => $conditionDate));
            $this->out(count($old) . ' aplicaciones viejas a agregar.');
            //Aqui paso los elementos, teniendo en cuenta que news es 0.
            foreach($old as $app){
                $havev = '';
                if(count($app['Version']) > 0){
                    $havev = json_encode($app['Version']);
                }

                $toOld = array(
                    'Apk' => array(
                        'id' => $app['Application']['id'],
                        'label' => $app['Application']['label'],
                        'version' => $app['Application']['version'],
                        'code' => $app['Application']['code'],
                        'size' => $app['Application']['size'],
                        'category' => $app['Category']['name'],
                        'description' => $app['Application']['description'],
                        'sdkversion' => $app['Application']['sdkversion'],
                        'downloads' => $app['Application']['downloads'],
                        'rating' => $app['Application']['rating'],
                        'have_data' => $app['Application']['have_data'],
                        'verificate' => $app['Application']['verificate'],
                        'recommended' => $app['Application']['recommended'],
                        'only_logged' => $app['Application']['only_logged'],
                        'uploader' => $app['User']['name'],
                        'news' => 0,
                        'have_version' => $havev,
                        'created' => $app['Application']['created'],
                    )
                );
                $this->Apk->create();
                if($this->Apk->save($toOld)){
                    $this->out('Agregada ' . $app['Application']['label']);
                    $i ++;
                }

            }
            $conditions = array(' Application.created > ' =>  $fecha->format('Y-m-d H:i:s'));
        // }else{
        //     $res = $this->in('La fecha de ultima actualizacion es null toda la BD se generara como nueva, desea proceder?', array('S','N'), 'N');
        //     if($res == 'N'){
        //         $this->out('Gracias por usar nuestro sistema.');
        //         die();
        //     }
        //     //si es null aqui preparo una query vacia para que todos sean nuevos
        //     $conditions = array();
        // }
        // $news = $this->Application->find('all', array(/*'limit' => 100,*/ 'conditions' => $conditions));
        // $this->out(count($news) . ' aplicaciones nuevas a agregar.');
        // $apks_added = "";
        // //Aqui paso los elementos, teniendo en cuenta que news es 1.
        // foreach($news as $app){
        //     $havev = '';
        //     if(count($app['Version']) > 0){
        //         $havev = json_encode($app['Version']);
        //     }
        //     $toOld = array(
        //         'Apk' => array(
        //             'id' => $app['Application']['id'],
        //             'label' => $app['Application']['label'],
        //             'version' => $app['Application']['version'],
        //             'code' => $app['Application']['code'],
        //             'size' => $app['Application']['size'],
        //             'category' => $app['Category']['name'],
        //             'description' => $app['Application']['description'],
        //             'sdkversion' => $app['Application']['sdkversion'],
        //             'downloads' => $app['Application']['downloads'],
        //             'rating' => $app['Application']['rating'],
        //             'have_data' => $app['Application']['have_data'],
        //             'verificate' => $app['Application']['verificate'],
        //             'recommended' => $app['Application']['recommended'],
        //             'only_logged' => $app['Application']['only_logged'],
        //             'uploader' => $app['User']['name'],
        //             'created' => $app['Application']['created'],
        //             'have_version' => $havev
        //         )
        //     );
        //     $this->Apk->create();
        //     if($this->Apk->save($toOld)){
        //         $this->out('Agregada ' . $app['Application']['label']);
        //         if($j < 10)
        //             $apks_added = $app['Application']['label'] . "\n";
        //         $j ++;
        //     }

        // }
        // / $apks_added .= " ...";


        //Copiar la BD desde update a index paraque los usuarios puedan descargarla
        
        copy($source, $destiny);

        //poner noticia que solicite a los usuarios que recarguen la BD para ver las aplicaciones nuevas.
        // $notice = array(
        //     'Noticy' => array(
        //         'title' => 'Actualizacion',
        //         'body' => 'Existen nuevas aplicaciones en el servidor, recargue desde su dispositivo android (usando configuracion->Recargar BD desde el servidor) o visite nuestro sitio. \v' . $apks_added,
        //         'user_id' => 1,
        //     )
        // );
        // $this->Noticy->create();
        // $this->Noticy->save($notice);
        //Actualizar la BD con la fecha actual
        $config['Configuration']['bd_update'] = 0;
        $config['Configuration']['last_db_update'] = date('Y-m-d H:i:s');
        // $this->Configuration->save($config);

        $this->out('Pasadas ' + ($i + $j) . ' aplicaciones de ellas ' . $j . ' nuevas.');
    }

    public function cleanbadapps(){
        $i = 0;
        //Limpiar applications
        $apps =  $this->Application->find('all', array());
        foreach($apps as $app){
            $info = array(
                'label' => $app['Application']['label'],
                'id' =>  $app['Application']['id']
            );
            if($this->censuredApk($info)){
                //elimino de la BD
                $this->Application->id =  $app['Application']['id'];
                $this->Application->delete();
                //elimino los archivos
                $root = $this->getBasePath() . 'webroot\\pool\\';
                $father = $root . $app['Application']['id'] . '\\';
                $version = $father . $app['Application']['version'] . '\\';
                $file = $version . $app['Application']['id'];
                //borrar apk
                unlink($file . '.apk');
                //borrar png
                unlink($file . '.png');
                //borrar carpetas
                rmdir($version);
                rmdir($father);
                $this->out("Eliminada la aplicaccion " . $app['Application']['label']);
                $i ++;
            }
        }
        //Limpiar versiones
        $vers =  $this->Version->find('all', array());
        foreach($vers as $app){
            $info = array(
                'label' => $app['Version']['label'],
                'id' =>  $app['Version']['application_id']
            );
            if($this->censuredApk($info)){
                //elimino de la BD
                $this->Version->id =  $app['Version']['id'];
                $this->Version->delete();
                //elimino los archivos
                $root = $this->getBasePath() . 'webroot\\pool\\';
                $father = $root . $app['Version']['application_id'] . '\\';
                $version = $father . $app['Version']['version'];
                $file = $version . $app['Version']['application_id'] . '\\';
                //borrar apk
                unlink($file . '.apk');
                //borrar png
                unlink($file . '.png');
                //borrar carpetas
                rmdir($version);
                rmdir($father);
                $this->out("Eliminada la aplicaccion " . $app['Version']['label']);
                $i ++;
            }
        }

        //Limpiar uploads
        $vers =  $this->Upload->find('all', array());
        foreach($vers as $app){
            $info = array(
                'label' => $app['Upload']['label'],
                'id' =>  $app['Upload']['name']
            );
            if($this->censuredApk($info)){
                //elimino de la BD
                $this->Version->id =  $app['Upload']['id'];
                $this->Version->delete();
                //elimino los archivos
                $root = $this->getBasePath() . 'webroot\\poolUpload\\';
                $father = $root . $app['Upload']['name'] . '\\';
                $version = $father . $app['Upload']['version'] . '\\';
                $file = $version . $app['Upload']['name'];
                //borrar apk
                unlink($file . '.apk');
                //borrar png
                unlink($file . '.png');
                //borrar carpetas
                rmdir($version);
                rmdir($father);
                $this->out("Eliminada la aplicaccion " . $app['Upload']['label']);
                $i ++;
            }
        }

        $this->out($i ." Aplicacciones eliminadas.");
    }

    public function deleteHuerfan(){
        $this->out("Elimina los ficheros de la carpeta pool y poolUpload que no tienen representacion en al BD. Por implementar");
    }

    //funciones auxiliares

    /*
     * Recibe el array que devuelve la funcion apk_info y devuelve true or false encaso de que alguna de
     * las palabras contenga total o parcialmente una de las palabras censuradas
     */
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

    /*
     * Se conecta a googleplay y recoge informacion sobre la categoria y la descripcion  de las aplicaciones
     * si se usa un proxy este sera un string con el siguiente formato
     * <usuario>:<contraseña>@<servidor>:<puerto> poner en el usage
     */
    private function get_contenido($id, $proxy = null)
    {
         // $div_contenido = array(array(), array('No obtenida'));
         // var_dump($div_contenido);
         // die();
        $url = 'https://play.google.com/store/apps/details?id=' . $id . '&hl=es';
        if (isset($proxy)) {
            $var = explode("@", $proxy);
            $auth = $var[0];
            $host = $var[1];
            $sLogin = base64_encode($auth);
            $aHTTP['http']['proxy'] = 'tcp://' . $host;
            $aHTTP['http']['request_fulluri'] = true;
            $aHTTP['http']['method'] = 'GET';
            $aHTTP['http']['header'] = "User-Agent: My PHP Script\r\n";
            $aHTTP['http']['header'] .= "Referer: http://play.google.com/\r\n";
            $aHTTP['http']['header'] .= "Proxy-Authorization: Basic $sLogin";
            $context = stream_context_create($aHTTP);
            $html = @file_get_contents($url, false, $context);
        } else {
            $html = @file_get_contents($url, false);
        }
        if ($html !== false) {
            //preg_match_all("/\<div\ id\=\"doc\-original\-text\" itemprop=\"description\"\>(.*?)\<\/div\>/", $html, $div_contenido);
            //preg_match_all("/\<a href\=\"\/store\/apps\/category\/(.*?)\?feature\=category\-nav\"\>(.*?)\<\/a\>/", $html, $categoria);

            //enero 05 2015
            //descripcion
            preg_match_all("/\<div\ class\=\"id\-app\-orig\-desc\"\>(.*?)\<\/div\>/", $html, $div_contenido); 
            //categoria  
            preg_match_all("/\<span\ itemprop\=\"genre\"\>(.*?)\<\/span\>/", $html, $categoria);
            //desarrollador
            preg_match_all("/\<div\ class\=\"content\"\>(.*?)\<\/div\>/", $html, $devel);
        }
        if(!isset($categoria)){
            $div_contenido = array(array(), array('No obtenida'));
            $categoria = array(array(), array(''));
            $devel = array(array(), array(''));
        }
        return array('description' => $div_contenido[1][0], 'category' => $categoria[1][0], 'devel' => $devel[1][0]);
    }
    /*
     * Funcion que copia un apk determinado hacia el pool
     */
    function copy_to_pool($filename, $info)
    {
        $root = $this->getBasePath() . 'webroot' . DS;
        if ($this->is_apk($filename)) {
            $path = $root . 'pool' . DS . $info['id'] . DS;
            if (!is_dir($path)) {
                 mkdir($path);
                chgrp($path, "www-data");
            }
            $path .=  $info['version'] . DS;
            if (!is_dir($path)) {
                mkdir($path);
                chgrp($path, "www-data");
            }
            $path .= $info['id'] ;
            //echo "Copiada " . $path ." \n";
            copy($filename, $path . '.apk');
            $this->apk_icon($path, $info['icon']);
        }
    }
    /*
    * Funcion analoga a copy_to_pool pero que copuia asia la carpeta de uploads
    */
    function copy_to_poolUpload($filename, $info){
        $root = $this->getBasePath() . 'webroot' . DS;
        if ($this->is_apk($filename)) {
            $path = $root . 'poolUpload' . DS . $info['id'] . DS;
            if (!is_dir($path)) {
                mkdir($path);
                chgrp($path, "www-data");
                chmod($path, 0777);
            }
            $path .=  $info['version'] . DS;
            if (!is_dir($path)) {
                mkdir($path);
                chgrp($path, "www-data");
                chmod($path, 0777);
            }
            $path .= $info['id'] ;
            //echo "Copiada " . $path ." \n";
            copy($filename, $path . '.apk');
            chgrp($path . '.apk', "www-data");
            chmod($path . '.apk', 0777);
            
            $this->apk_icon($path, $info['icon']);
            chgrp($path . '.png', "www-data");
            chmod($path . '.png', 0777);
            
        }
    }

    /*
     * Metodo que devuelve todos los apk que hay en una carpeta determinada
     */
    private function get_files($path, $data = array())
    {
        if (is_dir($path)) {
            if ($dh = opendir($path)) {
                while (($file = readdir($dh)) !== false) {
                    if ($file != "." && $file != "..") {
                        if ((!is_dir("$path/$file")) && ($this->is_apk("$path/$file"))) {
                            $data[] = "$path/$file";
                        } else {
                            $data = $this->get_files("$path/$file", $data);
                        }
                    }
                }
                closedir($dh);
            }
        }
        return $data;
    }

    private function esWindow(){
        if(stripos(' ' .php_uname('s'), "Windows") != ''){
            return true;
        }else{
            return false;
        }
    }

    /*
     * Crea el icono de un apk a partir del path sin la extencion de el apk y el nombre del recurso obtenido en icon
     */
    function apk_icon($filename, $resourse)
    {
        $root = $this->getBasePath() . 'webroot' . DS;
        if($this->esWindow()) {
            exec($root .'soft\\unzip -p "' . $filename . '.apk' . '" ' . $resourse . ' > ' . $filename . '.png');
        }else{
            exec('unzip -p "' . $filename . '.apk' . '" ' .  $resourse . ' > ' . $filename . '.png');
        }
    }

    /*
     * recive un path de un apk y debuelve la informacion contenida en su fichero de manifiesto
     */
    private function apk_info($APK)
    {
        $root = $this->getBasePath() . 'webroot' . DS;
        
        if($this->esWindow()) {
            $SIZE = filesize($APK);
            $SDK = exec($root . 'soft\\aapt dump --values badging ' . $APK . ' | ' . $root . 'soft\\grep ^sdkVersion: | ' . $root . 'soft\\cut -d' . '"' . '\'' . '" -f2 | ' . $root . 'soft\\head -1');
            $ID = exec($root . 'soft\\aapt dump --values badging ' . $APK . ' | ' . $root . 'soft\\grep ^package: | ' . $root . 'soft\\cut -d' . '"' . '\'' . '" -f2 | ' . $root . 'soft\\head -1');
            $LABEL = exec($root . 'soft\\aapt dump --values badging ' . $APK . ' | ' . $root . 'soft\\grep application-label | ' . $root . 'soft\\cut -d: -f2 | ' . $root . 'soft\\head -1 ');
            $LABEL = substr($LABEL,1, strlen($LABEL)- 2);
            $VERSION = exec($root . 'soft\\aapt dump --values badging ' . $APK . ' | ' . $root . 'soft\\grep ^package: | ' . $root . 'soft\\cut -d' . '"' . '\'' . '" -f4 | ' . $root . 'soft\\head -1 ');
            $CODE = exec($root . 'soft\\aapt dump --values badging ' . $APK . ' | ' . $root . 'soft\\grep ^package: | ' . $root . 'soft\\cut -d' . '"' . '\'' . '" -f6 | ' . $root . 'soft\\head -1 ');
            $RES = exec($root . 'soft\\aapt dump --values badging ' . $APK . ' | ' . $root . 'soft\\grep ^application: | ' . $root . 'soft\\cut -d= -f3 | ' . $root . 'soft\\head -1');
            $RES = substr($RES,1, strlen($RES)- 2);
            return array('id' => $ID, 'label' => $LABEL, 'version' => $VERSION, 'code' => $CODE, 'sdk' => $SDK, 'size' => $SIZE, 'icon' => $RES);
        }else{
            $SIZE = filesize($APK);
            $SDK = exec($root . 'soft/aapt dump --values badging ' . $APK . ' | grep ^sdkVersion: | cut -d\\\' -f2 | head -1');
            $ID = exec($root . 'soft/aapt dump --values badging ' . $APK . ' | grep ^package: | cut -d\\\' -f2 | head -1');
            $LABEL = exec($root . 'soft/aapt dump --values badging ' . $APK . ' | grep application-label | cut -d: -f2 | head -1 | sed s/\\\'//g');
            $VERSION = exec($root . '/soft/aapt dump --values badging ' . $APK . ' | grep ^package: | cut -d\\\' -f4 | head -1 ');
            $CODE = exec($root . '/soft/aapt dump --values badging ' . $APK . ' | grep ^package: | cut -d\\\' -f6 | head -1 ');
            $RES = exec($root . '/soft/aapt dump --values badging ' . $APK . ' | grep ^application: | cut -d= -f3 | head -1 | sed s/\\\'//g');
            return array('id' => $ID, 'label' => $LABEL, 'version' => $VERSION, 'code' => $CODE, 'sdk' => $SDK, 'size' => $SIZE, 'icon' => $RES);
        }
    }
    /*
     * Determina si el path de un fichero termina con la extencion apk
     */
    private function is_apk($filename)
    {
        return (substr(strrchr($filename, '.'), 1) == 'apk') ? true : false;
    }
    /*
     * Devuelve el path hasta la carpeta app del sistema
     */
    private function getBasePath(){
        $data = $_SERVER['argv'][2];
        //$this->out("Root Dir: " . substr($data,0, strlen($data) -1 ) . DS);
        return $data . DS;//substr($data,0, strlen($data) -1 ) . DS;
    }
}