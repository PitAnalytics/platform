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

//container
require_once '../app/core/container.php';


//root
$app->get('/', function (Request $request, Response $response, array $args) {

    $response->getBody()->write("plataforma GCP");
    return $response;

});

$app->get('/loader/history', \App\Controllers\Loader\LoadController::class.':history');
$app->get('/loader/load/{type}/{society}/{date}', \App\Controllers\Loader\LoadController::class.':load');
$app->run();

/*
$app->get('/balanza/ciclos', \App\Controllers\Loader\LoadController::class.':history');
$app->get('/balanza/ciclos/nuevo', \App\Controllers\Loader\LoadController::class.':history');
$app->get('/balanza/ciclos/retroceder', \App\Controllers\Loader\LoadController::class.':history');

$app->get('/balanza/cuentas', \App\Controllers\Loader\LoadController::class.':history');
$app->get('/balanza/cuentas/actualizar', \App\Controllers\Loader\LoadController::class.':history');

$app->get('/balanza/cecos[/busqueda/{empresa}/{ceco}]', \App\Controllers\Loader\LoadController::class.':history');
$app->get('/balanza/cecos/insertar', \App\Controllers\Loader\LoadController::class.':history');
$app->get('/balanza/cecos/actualizar', \App\Controllers\Loader\LoadController::class.':history');
$app->get('/balanza/cecos/eliminar', \App\Controllers\Loader\LoadController::class.':history');

*/

?>
