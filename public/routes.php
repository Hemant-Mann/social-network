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
    ),
    array(
        "pattern" => "user/search",
        "controller" => "users",
        "action" => "search"
    ),
    array(
        "pattern" => "user/profile",
        "controller" => "users",
        "action" => "profile"
    )
);

// add defined routes
foreach ($routes as $route) {
    $router->addRoute(new Framework\Router\Route\Simple($route));
}

// unset globals
unset($routes);
?>
