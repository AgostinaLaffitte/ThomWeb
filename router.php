<?php

require_once './Libs/response.php';
require_once './Libs/route.php';
require_once './App/Controllers/vehicle.controller.php';
require_once './App/Controllers/auth.controller.php';
require_once './App/Middlewares/jwt.auth.middleware.php';
require_once './config/config.php';


// base_url para direcciones y base tag
define('BASE_URL', '//'.$_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . dirname($_SERVER['PHP_SELF']).'/');

$router = new Router();
$router->addMiddleware(new JWTAuthMiddleware());

$router->addRoute('vehicle', 'GET', 'Fvehicel.controller', 'showHome');
$router->addRoute('vehicle/:id', 'GET', 'vehicel.controller', 'showVehicleDetails');
$router->addRoute('vehicle', 'POST', 'vehicel.controller', 'addVehicle');
$router->addRoute('vehicle/:id', 'DELETE', 'vehicel.controller', 'deleteVehicle');
$router->addRoute('vehicle/:id', 'PUT', 'vehicel.controller', 'editVehicle');


$router->addRoute('usuarios/token', 'GET','UserApiController','getToken');

$router->route($_GET['resource'], $_SERVER['REQUEST_METHOD']);

