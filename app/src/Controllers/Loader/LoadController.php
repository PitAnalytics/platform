<?php

namespace App\Controllers\Loader;

use App\Controllers\Controller as Controller;

use Psr\Container\ContainerInterface as Container;

class LoadController extends Controller{

    private $config;
    private $database;
    private $history;
    private $localLoader;
    private $schema;
    private $loader;

    public function __construct(Container $container){

        //INSTANCIACION DE DEPENDENCIAS 

        //tomamos el container y lo instanciamos por inyeccion de dependencias
        $this->container=$container;

        //tomamos la configuracion de proyecto
        $this->config=$this->container['config'];

        //mandamos llamar la base de datos
        $this->database=$this->container['database']($this->config->database());

        //mandamos llamar al historial y anidamos base de datos
        $this->history=$this->container['history']($this->database);

        //mandamos llamar al cargador de bigquery
        $this->localLoader=$this->container['localloader']('informe-211921');
        
        //mandamos llamar a la dependencia de esquemas
        $this->schema=$this->container['schema']('../app/files/schema');

        //mandamos a llamar la clase compuesta de loader
        $this->loader=$this->container['loader']($this->localLoader,$this->schema,$this->history);
        
    }

    public function load($request,$response,$args){

        //tomamos argumentos
        $type=$args['type'];
        $society=$args['society'];
        $date=$args['date'];

        //de estar disponible
        if(!$this->loader->available()){

            echo('busy');

        }
        else{

            //ejecutamos tarea de carga
           $loaded = $this->loader->load($type,$society,$date);

           if($loaded){

                echo('ok');

           }
           else{

            echo('error');

           }

        }

    }

    public function history($request,$response,$args){

        //prueba de esquema de historial
        $index=$this->loader->getHistory();

        //retornamos con header de json
        return $response->withJson($index);

    }

}

?>

