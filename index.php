<?php
use Src\Utils\Exception\ApiException;
use Src\Utils\Exception\ResourceNotFoundException;
use Src\Utils\Exception\InvalidDomainValueException;

date_default_timezone_set('America/Argentina/Buenos_Aires');

header("Access-Control-Allow-Origin: *"); // Cambiar a  peticiones desde {URL} FRONT-END
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");


// Cargamos configuración de composer
require_once __DIR__ . '/vendor/autoload.php';
// Inicializamos el routeador
require_once __DIR__ . '/app/Router/Routes.php';
// Inicializamos el autoloader
require_once __DIR__ . '/app/Autoloader/Autoloader.php';
// Utilizamos la libreria 'Dotenv' para cargar nuestros datos
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load(); 

// Cargamos el autoloader
spl_autoload_register(
    function ($class): void {
        Autoloader::register($class, [
            "src/Controller",
            "src/Service",
            "src/Entity",
            "src/Infrastructure",
            "src/Utils"
        ]);
    }
);

// Cargamos el routeador
$router = startRouter();

// Obtenemos el URL de donde está entrando el usuario
$url = $_SERVER["REQUEST_URI"];

// Eliminamos los parámetros (todo lo que viene después de '?')
$url = explode("?", $url)[0];

// Eliminamos el prefijo del proyecto
$basePath = "API-Domestic-Control-Stock";
$url = str_replace($basePath, "", $url);

try {
    // A partir del URL y del método, el Routeador decide por qué ruta entrar
    $router->resolve(
        $url,
        $_SERVER['REQUEST_METHOD']
    );
} catch (Throwable $e) {
    // Error PREDETERMINADO
    $status = 500;
    $message = 'Error interno del servidor.';

    if ($e instanceof ApiException) {
        $status = $e->statusCode();
        $message = $e->getMessage();

    } elseif ($e instanceof ResourceNotFoundException){
        $status = 404;
        $message = $e->getMessage();

    } elseif ($e instanceof InvalidDomainValueException) {
        $status = 422;
        $message = $e->getMessage();
        
    } 
    //--Develop--//
    if (($_ENV['APP_ENV'] ?? 'production') === 'development') {
        $message = $e->getMessage();
    }

    http_response_code($status);
    header('Content-Type: application/json; charset=utf-8');

    $response = [
        'status' => $status,
        'message' => $message
    ];

    if (($_ENV['APP_ENV'] ?? 'production') === 'development') {
        $response['exception'] = get_class($e);
        $response['file'] = $e->getFile();
        $response['line'] = $e->getLine();
        //$response['trace'] = $e->getTraceAsString();
    }

    echo json_encode($response, JSON_UNESCAPED_UNICODE);
}