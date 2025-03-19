<?php

require_once './Libs/response.php';
require_once './Libs/route.php';
require_once './App/Controllers/vehicles.controller.php';
//require_once './App/Controllers/auth.controller.php';
require_once './App/Middlewares/jwt.auth.middleware.php';
require_once './Config/config.php';


// base_url para direcciones y base tag
define('BASE_URL', '//'.$_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . dirname($_SERVER['PHP_SELF']).'/');

$router = new Router();
$router->addMiddleware(new JWTAuthMiddleware());

$router->addRoute('vehicles', 'GET', 'VehiclesController', 'showVehicles');
$router->addRoute('vehicle/:id', 'GET', 'VehiclesController', 'showVehicleDetails');
$router->addRoute('vehicle', 'POST', 'VehiclesController', 'addVehicle');
$router->addRoute('vehicle/:id', 'DELETE', 'VehiclesController', 'deleteVehicle');
$router->addRoute('vehicle/:id', 'PUT', 'VehiclesController', 'editVehicle');


//$router->addRoute('usuarios/token', 'GET','UserApiController','getToken');

$router->route($_GET['resource'], $_SERVER['REQUEST_METHOD']);

