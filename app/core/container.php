<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app = new \Slim\App(
    [
        'settings' => [
            'displayErrorDetails' => true,
            'responseChunkSize' => 8096
        ]
    ]
);


/********************************/
/**CONTENEDOR CON CONFIGURACION**/
/********************************/


//instanciamos el contenedor
$container=$app->getContainer();

//manadmos llamar configuracion
$container['config']=function($path){

    return new App\Config\Config('../app/src/Config/Config.json');

};

/********************************/
/****DEPENDENCIAS DE COMPOSER****/
/********************************/

$container['database']=function($container){

    return function($c){

        return new Medoo\Medoo($c);

    };

};

/********************************/
/*******DEPENDENCIAS PROPIAS*****/
/********************************/

$container['bigquery']=function($container){

    return function($config){

        return new App\Dependencies\BigQuery($config);

    };

};

$container['localloader']=function ($container) {

    return function ($id){

        return new App\Dependencies\LocalLoader($id);

    };
    
};

$container['schema']=function ($container) {

    return function ($path){

        return new App\Dependencies\Schema($path);

    };

};

/************************************/
/******MODULOS DE DATOS SIMPLES******/
/************************************/

$container['history']=function ($container) {

    return function($database){

        return new App\Modules\History($database);

    };

};

/************************************/
/*************SUBSISTEMAS************/
/************************************/

$container['loader']=function($container){

    return function($l,$f,$h){

        return App\Subsystems\Loader::INSTANCIATE($l,$f,$h);

    };

};



?>