<?php

require_once './Libs/response.php';
require_once './Libs/route.php';
require_once './App/Controllers/film.controller.php';
require_once './App/Controllers/review.controller.php';
require_once './App/Controllers/producer.controller.php';
require_once './App/Controllers/auth.controller.php';
require_once './App/Middlewares/jwt.auth.middleware.php';
require_once './config/config.php';


// base_url para direcciones y base tag
define('BASE_URL', '//'.$_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . dirname($_SERVER['PHP_SELF']).'/');

$router = new Router();
$router->addMiddleware(new JWTAuthMiddleware());

$router->addRoute('peliculas', 'GET', 'FilmsController', 'showHome');
$router->addRoute('peliculas/:id', 'GET', 'FilmsController', 'showFilmDetails');
$router->addRoute('peliculas', 'POST', 'FilmsController', 'addFilm');
$router->addRoute('peliculas/:id', 'DELETE', 'FilmsController', 'deleteFilm');
$router->addRoute('peliculas/:id', 'PUT', 'FilmsController', 'editFilm');

$router->addRoute('productoras', 'GET', 'producerController', 'showProducers');
$router->addRoute('productoras/:id', 'GET', 'producerController', 'seeProducer');
$router->addRoute('productoras', 'POST', 'producerController', 'addProducer');
$router->addRoute('productoras/:id', 'DELETE', 'producerController', 'deleteProducer');
$router->addRoute('productoras/:id', 'PUT', 'producerController', 'modifyProducers');

$router->addRoute('reseña', 'GET', 'reviewController', 'showReview');
$router->addRoute('reseñas', 'POST', 'reviewController', 'addReview');
$router->addRoute('reseñas/:id', 'DELETE', 'reviewController', 'deleteReview');
$router->addRoute('reseñas/:id', 'PUT', 'reviewController', 'modifyReview');

$router->addRoute('usuarios/token', 'GET','UserApiController','getToken');

$router->route($_GET['resource'], $_SERVER['REQUEST_METHOD']);

