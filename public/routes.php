<?php

// define routes
$routes = array(
    array(
        "pattern" => "user/register",
        "controller" => "users",
        "action" => "register"
    ),
    array(
        "pattern" => "user/login",
        "controller" => "users",
        "action" => "login"
    )
);

// add defined routes
foreach ($routes as $route) {
    $router->addRoute(new Framework\Router\Route\Simple($route));
}

// unset globals
unset($routes);
?>
