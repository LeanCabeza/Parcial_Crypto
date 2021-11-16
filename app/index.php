<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Handlers\Strategies\RequestHandler;
use Slim\Routing\RouteCollectorProxy;
use Slim\Routing\RouteContext;

require __DIR__ . '/../vendor/autoload.php';
require_once './controllers/UsuarioController.php';
require_once './controllers/CryptoController.php';
require_once './controllers/VentaController.php';
require_once './db/AccesoDatos.php';
require_once './middlewares/AutenticacionMiddelware.php';
require_once './middlewares/UsuariosMiddleware.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$app = AppFactory::create();
$app->setBasePath('/ParcialCrypto');
$app->addRoutingMiddleware();
$app->addBodyParsingMiddleware();

$errorMiddleware = $app->addErrorMiddleware(true, true, true);

$app->get('/', function (Request $request, Response $response, $args) {
    $response->getBody()->write("2DO PARCIAL LEANDRO CABEZA");
    return $response;
});


// USUARIOS
$app->group('/autenticacion', function (RouteCollectorProxy $group) {
  $group->post('/login', \UsuarioController::class . ':Login');
});

 // CRYPTO
 $app->group('/crypto', function (RouteCollectorProxy $group) {
   //ALTA CRYPTO, SOLO ADMIN.
  $group->post('/', \CryptoController::class . ':CargarUno')
  ->add(\UsuariosMiddleware::class . ':VerificarAccesoAdmin')
  ->add(\AutenticacionMiddelware::class . ':VerificarToken');
  // LISTAR CYPTO, SIN AUTENTICACION
  $group->get('/', \CryptoController::class . ':listarCryptos');
  // LISTAR POR NACIONALIDAD, SIN AUTENTICACION
  $group->get('/{nacionalidad}', \CryptoController::class . ':listarCryptosPorNacionalidad');
  // LISTAR POR ID,CUALQUIER USUARIO REGISTRADO
  $group->get('/listarPorId/{id}', \CryptoController::class . ':listarPorId')  
  ->add(\AutenticacionMiddelware::class . ':VerificarToken');
   //BORRAR POR ID, SOLO ADMIN
   $group->delete('/{id}', \CryptoController::class . ':BorrarCryptoPorId')
   ->add(\UsuariosMiddleware::class . ':VerificarAccesoAdmin')
   ->add(\AutenticacionMiddelware::class . ':VerificarToken');
  //MODIFICAR POR ID, SOLO ADMIN
    $group->put('/modificar', \CryptoController::class . ':ModificarPorId')
    ->add(\UsuariosMiddleware::class . ':VerificarAccesoAdmin')
    ->add(\AutenticacionMiddelware::class . ':VerificarToken');
});

// VENTAS
$app->group('/ventas', function (RouteCollectorProxy $group) {
 // ALTA VENTA, CUALQUIER USUARIO REGISTRADO
  $group->post('/crear', \VentaController::class . ':CargarUno')
  ->add(\AutenticacionMiddelware::class . ':VerificarToken');

// VENTAS DE CRYPTOS ALEMANAS, SOLO ADMIN
  $group->get('/ventasAlemanas', \VentaController::class . ':TreaerVentasAlemanas')  
  ->add(\UsuariosMiddleware::class . ':VerificarAccesoAdmin')
  ->add(\AutenticacionMiddelware::class . ':VerificarToken');
// LISTAR USUARIOS QUE COMPRARON "X" CRYPTO.
  $group->get('/UsuariosQueCompraron/{UsuariosQueCompraron}', \VentaController::class . ':TreaerUsuariosQueCompraron')
  ->add(\UsuariosMiddleware::class . ':VerificarAccesoAdmin')
  ->add(\AutenticacionMiddelware::class . ':VerificarToken');
// GENERAR PDF DE USUARIOS QUE COMPRARON
$group->get('/pdf', \VentaController::class . ':ObtenerPdf');
});


// Run app
$app->run();

