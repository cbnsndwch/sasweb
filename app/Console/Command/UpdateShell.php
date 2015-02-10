<?php
/**
 * Created by JetBrains PhpStorm.
 * User: chenry
 * Date: 3/01/15
 * Time: 03:20 AM
 * To change this template use File | Settings | File Templates.
 */

class UpdateShell extends AppShell{

    var $uses = array(
        'Apk',
        'Configuration',
        'Application',
        'Version',
    );

    //var_dump($_SERVER['argv'][2]); esta es la forma de obtener la ruta app sin el slash al final
    public function main() {
        $this->out('Aqui tengo que poner el usage que indica como usar este shell, importante si alguien mas va a administrar el sitio');
    }

    public function updatecategorythrowindexdb(){
        $app = $this->Apk->find('all',
            array(
                'conditions' => array(
                    'Apk.category <>' => 'Untrusted',
                    'Apk.category is not null' )
            )
        );
        $this->out(count($app) . ' apks con descripcion');
        foreach($app as $apk){
            //verificar que existe alguna applicacion con este id si existe actualizar su categoria
            //hacer lo mismo con la tabla versiones
            $applications = $this->Application->find('all',
                array(
                    'conditions' => array(
                        'Application.id' => $apk['Apk']['id']
                    )
                )
            );
            $this->out('Procesando ' . $apk['Apk']['label']);
            foreach($applications as $application){
                $application['Application']['category'] = $apk['Apk']['category'];
                $application['Application']['description'] = $apk['Apk']['description'];
                $this->Application->save($application);
            }
            //versiones
            $versions = $this->Version->find('all',
                array(
                    'conditions' => array(
                        'Version.application_id' => $apk['Apk']['id']
                    )
                )
            );
            foreach($versions as $version){
                $version['Version']['category'] = $apk['Apk']['category'];
                $version['Version']['description'] = $apk['Apk']['description'];
                $this->Version->save($version);
            }
        }
    }

    /*
     * En el proceso de desarrollo pasara la info de index.php a la bd principal
     * ojo este metodo sera eliminado una vez se tenga llana la bd
     * este es solo para ahorrar el proceso de creacion inicial
     * $this->args[0]
     */
    public function updatepass(){
//        var_dump($this->argv);
//        $this->out();

        $app = $this->Apk->find('all', array());
        foreach($app as $apk){

            $options = array('conditions' => array('Application.id' => $apk['Apk']['id']));
            $app =  $this->Application->find('first', $options);
            if(!isset($app['Application']['id'])){//si la aplicacion no existe la inserto sin problemas
                $toINsert = array();
                $toINsert['Application'] = array();
                $toINsert['Application']['id'] = $apk['Apk']['id'];
                $toINsert['Application']['label'] = $apk['Apk']['label'];
                $toINsert['Application']['version'] = $apk['Apk']['version'];
                $toINsert['Application']['code'] = $apk['Apk']['code'];
                $toINsert['Application']['category'] = $apk['Apk']['category'];
                $toINsert['Application']['description'] = $apk['Apk']['description'];//esto esta en prueba por ahora pasare null
                $toINsert['Application']['sdkversion'] = $apk['Apk']['sdkversion'];// esto esta en veremos
                $toINsert['Application']['downloads'] = 0;
                $toINsert['Application']['rating'] = 0;
                $toINsert['Application']['have_data'] = 0;
                //lo inserto en app sin problema alguna ya que no esta
                if ($this->Application->save($toINsert)) {
                    $this->out($apk['Apk']['id'] . ' Fue agregada con exito');
                }
            }else{
                //si la app existe entonces hago las comprobaciones de version
                if($apk['Apk']['version'] > $app['Application']['version']){
                    //si la version a insertar es mayor, inserto la nueva y pongo en version la que esta en aplicacion
                    $toVErsion = array();
                    $toVErsion['Version'] = array();
                    $toVErsion['Version']['application_id'] = $app['Application']['id'];
                    $toVErsion['Version']['label'] = $app['Application']['label'];
                    $toVErsion['Version']['version'] = $app['Application']['version'];
                    $toVErsion['Version']['code'] = $app['Application']['code'];
                    $toVErsion['Version']['category'] = $app['Application']['category'];
                    $toVErsion['Version']['description'] = $app['Application']['description'];//esto esta en prueba por ahora pasare null
                    $toVErsion['Version']['sdkversion'] = $app['Application']['sdkversion'];// esto esta en veremos
                    $toVErsion['Version']['downloads'] = $app['Application']['downloads'];
                    $toVErsion['Version']['rating'] = $app['Application']['rating'];
                    $toVErsion['Version']['have_data'] = $app['Application']['have_data'];
                    if ($this->Version->save($toVErsion)) {
                        $toINsert = array();
                        $toINsert['Application'] = array();
                        $toINsert['Application']['id'] = $apk['Apk']['id'];
                        $toINsert['Application']['label'] = $apk['Apk']['label'];
                        $toINsert['Application']['version'] = $apk['Apk']['version'];
                        $toINsert['Application']['code'] = $apk['Apk']['code'];
                        $toINsert['Application']['category'] = $apk['Apk']['category'];
                        $toINsert['Application']['description'] = $apk['Apk']['description'];//esto esta en prueba por ahora pasare null
                        $toINsert['Application']['sdkversion'] = $apk['Apk']['sdkversion'];// esto esta en veremos
                        $toINsert['Application']['downloads'] = 0;
                        $toINsert['Application']['rating'] = 0;
                        $toINsert['Application']['have_data'] = 0;
                        //lo inserto en app sin problema alguna ya que no esta
                        if ($this->Application->save($toINsert)) {
                            $this->out($apk['Apk']['id'] . ' Fue agregada con exito');
                        }
                    }
                }else if($apk['Apk']['version'] < $app['Application']['version']){
//                    si la version es menor, inserto si no esta en versiones
                    $options = array('conditions' => array(
                        'Version.application_id' => $apk['Apk']['id'],
                        'Version.version' => $apk['Apk']['version']
                    ));
                    $ver =  $this->Version->find('first', $options);
                    if(!isset($ver['Application']['application_id'])){//si no esta que es lo que deveria pasar, entonces la inserto
                        $toINsert = array();
                        $toINsert['Version'] = array();
                        $toINsert['Version']['application_id'] = $apk['Apk']['id'];
                        $toINsert['Version']['label'] = $apk['Apk']['label'];
                        $toINsert['Version']['version'] = $apk['Apk']['version'];
                        $toINsert['Version']['code'] = $apk['Apk']['code'];
                        $toINsert['Version']['category'] = $apk['Apk']['category'];
                        $toINsert['Version']['description'] = $apk['Apk']['description'];//esto esta en prueba por ahora pasare null
                        $toINsert['Version']['sdkversion'] = $apk['Apk']['sdkversion'];// esto esta en veremos
                        $toINsert['Version']['downloads'] = 0;
                        $toINsert['Version']['rating'] = 0;
                        $toINsert['Version']['have_data'] = 0;
                        if ($this->Version->save($toINsert)) {
                            $this->out($apk['Apk']['id'] . ' Fue agregada con exito');
                        }
                    }
                }
            }






        }

    }
}