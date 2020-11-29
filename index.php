<?php 

require 'vendor/autoload.php';

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

$request = Laminas\Diactoros\ServerRequestFactory::fromGlobals(
    $_SERVER, $_GET, $_POST, $_COOKIE, $_FILES
);

$responseFactory = new \Laminas\Diactoros\ResponseFactory();

$strategy = new League\Route\Strategy\JsonStrategy($responseFactory);
$router   = (new League\Route\Router)->setStrategy($strategy);

$router->map('GET', '/apiVersion/{parametro}', function (ServerRequestInterface $request, array $args) : array {
    return [
        'textoRetorno'   => 'Esta es una respuesta desde la API',
        'version' => 1,
        'parametro' => $args["parametro"]
    ];
});

$response = $router->dispatch($request);

// send the response to the browser
(new Laminas\HttpHandlerRunner\Emitter\SapiEmitter)->emit($response);