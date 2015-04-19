<?php

// define routes
$routes = array(
    array(
        "pattern" => "register",
        "controller" => "users",
        "action" => "register"
    ),
    array(
        "pattern" => "home",
        "controller" => "home",
        "action" => "index"
    ),
    array(
        "pattern" => "login/?",
        "controller" => "users",
        "action" => "login",
        "parameters" => array("id")
    ),
    array(
        "pattern" => "logout",
        "controller" => "users",
        "action" => "logout"
    ),
    array(
        "pattern" => "search",
        "controller" => "users",
        "action" => "search"
    ),
    array(
        "pattern" => "profile",
        "controller" => "users",
        "action" => "profile"
    ),
    array(
        "pattern" => "settings",
        "controller" => "users",
        "action" => "settings"
    ),
    array(
        "pattern" => "unfriend/?",
        "controller" => "users",
        "action" => "friend",
        "parameters" => array("id")
    ),
    array(
        "pattern" => "friend/?",
        "controller" => "users",
        "action" => "friend",
        "parameters" => array("id")
    )
);

// add defined routes
foreach ($routes as $route) {
    $router->addRoute(new Framework\Router\Route\Simple($route));
}

// unset globals
unset($routes);
?>
