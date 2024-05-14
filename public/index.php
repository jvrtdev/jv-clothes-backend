<?php

use App\Controllers\UserController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();

//autoriza a rota options 
$app->options('/{routes:.+}', function ($request, $response, $args) {
    return $response;
  });
  
  //funcao para habilitar o cors
  $app->add(function ($request, $handler) {
    $response = $handler->handle($request);
    return $response
      ->withHeader('Access-Control-Allow-Origin', '*')
      ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
      ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
  });


$app->get('/', function (Request $request, Response $response, $args) {
    $response->getBody()->write("Hello world!");
    return $response;
});

$app->post('/user/create', UserController::class . ':createUser');
$app->post('/user/login', UserController::class . ':loginUser');

$app->run();