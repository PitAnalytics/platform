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
//
$container=$app->getContainer();

$container['config']=function($path){

    return new App\Config\Config('../app/src/Config/Config.json');

};

//
$container['localloader']=function ($container) {

    return function ($id){

        return new App\Modules\LocalLoader($id);

    };
    
};

$container['schema']=function ($container) {

    return function ($path){

        return new App\Modules\Schema($path);

    };

};

$container['history']=function ($container) {

    return function($database){

        return new App\Modules\History($database);

    };

};

$container['database']=function($container){

    return function($c){

        return new Medoo\Medoo($c);

    };

};

$container['bigquery']=function($container){

    return function($config){

        return new App\Dependencies\BigQuery($config);

    };

};

?>