<?php
//C:\xampp\htdocs\slim-php-deployment\app\Modelo
include ("./Controlador/empleadoControlador.php");
include ("./Controlador/encuestaControlador.php");
include ("./Controlador/mesaControlador.php");
include ("./Controlador/pedidoControlador.php");
include ("./Controlador/productoControlador.php");
include ("./Middlewares/autorizacionMiddleware.php");
include ("./Middlewares/JsonMiddleware.php");
include ("./Controlador/loginControlador.php");
include ("./Controlador/productosSolicitadosControlador.php");
// Error Handling
error_reporting(-1);
ini_set('display_errors', 1);

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Slim\Routing\RouteCollectorProxy;

require __DIR__ . '/../vendor/autoload.php';
//productoSQL::InsertarProducto(new producto("Pizza",2000,tipoProducto::Cocinero,15));

// Instantiate App
$app = AppFactory::create();
$app->setBasePath("/slim-php-deployment/app");
// Add error middleware
$app->addErrorMiddleware(true, true, true);

// Add parse body
$app->addBodyParsingMiddleware();
//corchetes quiere decir opcional
// Routes


//PARA EVITAR ESCRIBIR LA LINEA $app->add(new JsonMiddleware());
$app->add(new JsonMiddleware());

$app->group('/pedido', function (RouteCollectorProxy $group) {
    $group->get('[/]', \pedidoControlador::class . ':TraerTodos');  
    $group->get('/{id}', \pedidoControlador::class . ':ObtenerPedidoxId');
    $group->post('[/]', \pedidoControlador::class . ':Insertar');
  })->add(new AutorizacionMiddleware("Mozo"));

  $app->group('/encuesta', function (RouteCollectorProxy $group) {
    $group->get('[/]', \EncuestaControlador::class . ':TraerEncuestas');
    $group->get('/{id}', \EncuestaControlador::class . ':ObtenerEncuestaxId');
    $group->post('[/]', \EncuestaControlador::class . ':Insertar');
  });

  $app->group('/empleado', function (RouteCollectorProxy $group) {
    $group->get('[/]', \EmpleadoControlador::class . ':ObtenerTodos');
    $group->get('/{id}', \EmpleadoControlador::class . ':ObtenerEmpleadoxId');
    $group->put('/{id}', \EmpleadoControlador::class . ':Modificar');
    $group->put('/{id}/baja', \EmpleadoControlador::class . ':Borrar');
    $group->post('[/]', \EmpleadoControlador::class . ':Insertar');
  })->add(new AutorizacionMiddleware("Socio"));


  $app->group('/mesa', function (RouteCollectorProxy $group) {
     $group->get('[/]', \mesaControlador::class . ':TraerMesas');
    $group->get('/{id}', \mesaControlador::class . ':ObtenerMesaxId');
    $group->post('[/]', \mesaControlador::class . ':InsertarMesa');
  })->add(new AutorizacionMiddleware("Mozo"));

  $app->group('/producto', function (RouteCollectorProxy $group) {
    $group->get('[/]', \ProductoControlador::class . ':TraerTodos');
    $group->get('/{id}', \ProductoControlador::class . ':ObtenerPedidoxId');
   $group->post('[/]', \ProductoControlador::class . ':Insertar');
 });

  $app->group('/login', function (RouteCollectorProxy $group) {
    $group->post('[/]', \LoginControlador::class . ':VerificarExistenciaUsuario');
 });
 
$app->get('[/]', function (Request $request, Response $response) {
    $payload = json_encode(array("mensaje" => "Slim Framework 4 PHP"));
    $response->getBody()->write($payload);
    return $response->withHeader('Content-Type', 'application/json');
});

$app->group('/productosolicitado', function (RouteCollectorProxy $group) {
   $group->put('[/]', \ProductoSolicitadoControlador::class . ':CambiarEstado');
   $group->get('[/]', \ProductoSolicitadoControlador::class . ':ListarPorTipo');
   $group->post('[/]', \ProductoSolicitadoControlador::class . ':Insertar');
});

$app->run();
?>
