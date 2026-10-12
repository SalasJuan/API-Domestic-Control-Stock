<?php
use Src\Utils\Exception\ApiException;
use Src\Utils\Exception\ResourceNotFoundException;

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
$basePath = "controlStock-API";
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
    } elseif ($e instanceof PDOException && $e->getCode() === '23000'){
        $status = 409;
        $message = 'La operación entra en conflicto con los datos existentes o con una relación de la base de datos.';
    }

    http_response_code($status);
    header('Content-Type: application/json; charset=utf-8');

    echo json_encode([
        'status' => $status,
        'message' => $message
    ], JSON_UNESCAPED_UNICODE);
}
