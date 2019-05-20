<?php

namespace App\Controllers\Balanza;

use App\Controllers\Controller as Controller;

use Psr\Container\ContainerInterface as Container;

class CicleController extends Controller{

    private $config;
    private $database;

    public function __construct(Container $container){

        //INSTANCIACION DE DEPENDENCIAS

        //tomamos el container y lo instanciamos por inyeccion de dependencias
        $this->container=$container;

        //tomamos la configuracion de proyecto
        $this->config=$this->container['config'];

        //mandamos llamar la base de datos
        $this->database=$this->container['database']($this->config->database());


        
    }

    public function index(){

        $cicles =$this->cicle->index();

        return $response->withJson($cicles);

        echo('cool');

    }

}

?>