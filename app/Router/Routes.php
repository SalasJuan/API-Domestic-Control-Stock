<?php 

include_once "Route.php";
include_once "Router.php";

function startRouter(): Router 
{
    // Inicializamos el array de rutas
    $routes = [];

    include_once "Routes/UserRoutes.php";//Ruta user
    $routes = array_merge($routes, UserRoutes::getRoutes());

    include_once "Routes/ProductRoutes.php";//Ruta product
    $routes = array_merge($routes, ProductRoutes::getRoutes());

    include_once "Routes/CategoryRoutes.php";//Ruta category
    $routes = array_merge($routes, CategoryRoutes::getRoutes());

    include_once "Routes/BrandRoutes.php";//Ruta brand
    $routes = array_merge($routes, BrandRoutes::getRoutes());

    include_once "Routes/PurchaseRoutes.php";//Ruta purchase
    $routes = array_merge($routes, PurchaseRoutes::getRoutes());

    include_once "Routes/PurchaseDetailRoutes.php";//Ruta purchaseDetail
    $routes = array_merge($routes, PurchaseDetailRoutes::getRoutes());
    
    include_once "Routes/LotRoutes.php";//Ruta lot
    $routes = array_merge($routes, LotRoutes::getRoutes());

    // Como las rutas en este momento son primitivas, tenemos que encapsularlas en un DTO
    $routesClass = [];
    foreach ($routes as $route) {
        // Pasamos de las rutas de tipo array a tipo DTO
        $routesClass[] = Route::fromArray($route);
    }
    
    // Retornamos un nuevo ruteador
    return new Router($routesClass);
}
