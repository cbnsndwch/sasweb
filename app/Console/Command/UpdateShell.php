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
        'Category',
        'Application',
        'Version',
    );

    
    

    //var_dump($_SERVER['argv'][2]); esta es la forma de obtener la ruta app sin el slash al final
    public function main() {
        $this->out('Aqui tengo que poner el usage que indica como usar este shell, importante si alguien mas va a administrar el sitio');
    }

//pesquisa la tabla categorias con el formato de el nombre de la categoria en texto y pasa las categorias a la tabla correcta
    public function category_make(){
        $sinclasificar = "Sin Clasificar";
        //aqui recojo todas las categorias
        $query = 'Select distinct App.category FROM applications as App where App.category != ""';
        $categorys = $this->Application->query($query);

        //agrega la por defecto
        $noesta = $this->Category->find('first', array('conditions'=>array('Category.name' => $sinclasificar)));
        if (!$noesta) {
            $toINsert = array(
                'Category' => array(
                    'name' => $sinclasificar
                )
            );
            //lo inserto en app sin problema alguna ya que no esta
           $this->Category->create();
            if ($this->Category->save($toINsert)) {                        
                $this->out($sinclasificar . ' Fue agregada con exito a la tabla Categorias.');
            }
        }

        //por cada una de las categorias agrego una entrada en la BD
        foreach ($categorys as $cat) {
                //validar si esa categoria no existe
            if($cat['App']['category'] === 'Terceros' || $cat['App']['category'] === 'Temporalmente nada') continue;
            $noesta = $this->Category->find('first', array('conditions'=>array('Category.name' => $cat['App']['category'])));
            if (!$noesta) {
                $toINsert = array(
                    'Category' => array(
                        'name' => $cat['App']['category']
                    )
                );
                //lo inserto en app sin problema alguna ya que no esta
               $this->Category->create();
                if ($this->Category->save($toINsert)) {                        
                    $this->out($cat['App']['category'] . ' Fue agregada con exito a la tabla Categorias.');
                }
            }
        }
    }
    /**
    * Pasa la informacion de la tabla version a la tabla aplicacion antes de eliminar esta
    **/
    public function vaciar_versiones(){


        $versions =  $this->Version->find('all', array());
        foreach ($versions as $v) {  
            $settings =array(
            'conditions' => array(
                'Application.parent_id is null',
                'Application.name' =>  $v['Version']['application_id']
                )
            );
            $app =  $this->Application->find('first', $settings);
            if(!isset($app['Application']))continue;
            $toAdd = array(
                'Application' => array(
                    'name' => $v['Version']['application_id'],
                    'label' => $v['Version']['label'],
                    'version' => $v['Version']['version'],
                    'code' => $v['Version']['code'],
                    'size' => $v['Version']['size'],
                    'category' => $v['Category']['name'],
                    'description' => $v['Version']['description'],
                    'sdkversion' => $v['Version']['sdkversion'],
                    'downloads' => $v['Version']['downloads'],
                    'rating' => $v['Version']['rating'],
                    'have_data' => $v['Version']['have_data'],
                    'verificate' => 0,
                    'recommended' => 0,
                    'users_id' => $v['Version']['users_id'],
                    'created' => $v['Version']['created'],
                    'modified' => $v['Version']['modified'],
                    'developer'=> $v['Version']['developer'],
                    'parent_id' => $app['Application']['id']
                )
            );

            $this->Application->create();
            if($this->Application->save($toAdd)){
                $this->Version->id = $v['Version']['id'];
                $this->Version->delete();
                $this->out('Se agrego a Aplicaciones ' . $v['Version']['label']);
            }

        }   

    }
    /**
    * Este metodo se encarga de poner el id correspondiente a la categoria en cada aplicacion y en caso de que la aplicacion 
    * tenga una categoria invalida arega el especial que es "Sin Clasificar"    
    */
    public function update_application_struct(){
        $bad_category = array('Terceros','Temporalmente nada', '');
        //primero executo el creador de la tabla de categorias por si queda una fuera
        $this->category_make();
        //para todas las applicaciones
        $applications =  $this->Application->find('all', array());
         // var_dump($applications);die();
        foreach ($applications as $app) {  
            if(is_null($app['Application']['category'])){
                 $cat_id = 1;
             }else{
                //si existe la categoria cojo el id y se lo pongo en la aplicacion y la salvo
                //si no existe o es una de las palabras raras entonces la categoria es 111q1q
                $noesta = $this->Category->find('first', array('conditions'=>array('Category.name' => $app['Application']['category'])));            
                $cat_id = 0;
                if (!$noesta) {                    
                    //verifico que no sea una de las palabras qeu no puede ir
                    if(!in_array($app['Application']['category'], $bad_category)){                       
                        //sino es una mala palabra la inserto
                        $toINsert = array(
                            'Category' => array(
                                'name' => $app['Application']['category']
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
            }
            //cambio el codigo de la aplicacionn y borro la categoria
            $app['Application']['categories_id'] = $cat_id;
            // $app['category'] = '';
            if ($this->Application->save($app)) {                        
                    $this->out($app['Application']['label'] . ' Fue actualizada con exito.');
                }
        }
    }

    public function update_version_struct(){
        $bad_category = array('Terceros','Temporalmente nada', '');
        //primero executo el creador de la tabla de categorias por si queda una fuera
        $this->category_make();
        //para todas las applicaciones
        $applications =  $this->Version->find('all', array());
         // var_dump($applications);die();
        foreach ($applications as $app) {  
            if(is_null($app['Version']['category'])){
                 $cat_id = 1;
             }else{
                //si existe la categoria cojo el id y se lo pongo en la aplicacion y la salvo
                //si no existe o es una de las palabras raras entonces la categoria es 111q1q
                $noesta = $this->Category->find('first', array('conditions'=>array('Category.name' => $app['Version']['category'])));            
                $cat_id = 0;
                if (!$noesta) {                    
                    //verifico que no sea una de las palabras qeu no puede ir
                    if(!in_array($app['Version']['category'], $bad_category)){                       
                        //sino es una mala palabra la inserto
                        $toINsert = array(
                            'Category' => array(
                                'name' => $app['Version']['category']
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
            }
            //cambio el codigo de la aplicacionn y borro la categoria
            $app['Version']['categories_id'] = $cat_id;
            // $app['category'] = '';
            if ($this->Version->save($app)) {                        
                    $this->out($app['Version']['label'] . ' Fue actualizada con exito.');
                }
        }
    }
}