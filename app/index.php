<?php
//C:\xampp\htdocs\slim-php-deployment\app\Modelo
include ("./Controlador/empleadoControlador.php");
include ("./Controlador/encuestaControlador.php");
include ("./Controlador/mesaControlador.php");
include ("./Controlador/pedidoControlador.php");
include ("./Controlador/productoControlador.php");

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
$app->group('/pedido', function (RouteCollectorProxy $group) {

    $group->get('[/]', \pedidoControlador::class . ':TraerTodos');  
    $group->get('/{id}', \pedidoControlador::class . ':ObtenerPedidoxId');
    $group->post('[/]', \pedidoControlador::class . ':Insertar');
  });

  $app->group('/encuesta', function (RouteCollectorProxy $group) {
    $group->get('[/]', \EncuestaControlador::class . ':TraerEncuestas');
    $group->get('/{id}', \EncuestaControlador::class . ':ObtenerEncuestaxId');
    $group->post('[/]', \EncuestaControlador::class . ':Insertar');
  });
  $app->group('/empleado', function (RouteCollectorProxy $group) {
    $group->get('[/]', \EmpleadoControlador::class . ':TraerEmpleados');
    $group->get('/{id}', \EmpleadoControlador::class . ':ObtenerEmpleadoxId');
    $group->post('[/]', \EmpleadoControlador::class . ':InsertarEmpleado');
  });
  $app->group('/mesa', function (RouteCollectorProxy $group) {
     $group->get('[/]', \mesaControlador::class . ':TraerMesas');
    $group->get('/{id}', \mesaControlador::class . ':ObtenerMesaxId');
    $group->post('[/]', \mesaControlador::class . ':InsertarMesa');
  });
  $app->group('/producto', function (RouteCollectorProxy $group) {
    $group->get('[/]', \ProductoControlador::class . ':TraerProductos');
    $group->get('/{id}', \ProductoControlador::class . ':ObtenerProductoxId');
   $group->post('[/]', \ProductoControlador::class . ':InsertarProducto');
 });
$app->run();
?>
