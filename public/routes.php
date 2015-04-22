<?php

// define routes
$routes =  [
    [
        "pattern" => "register",
        "controller" => "users",
        "action" => "register"
    ],
    [
        "pattern" => "home",
        "controller" => "home",
        "action" => "index"
    ],
    [
        "pattern" => "login/?",
        "controller" => "users",
        "action" => "login",
        "parameters" => ["id"]
    ],
    [
        "pattern" => "logout",
        "controller" => "users",
        "action" => "logout"
    ],
    [
        "pattern" => "search",
        "controller" => "users",
        "action" => "search"
    ],
    [
        "pattern" => "profile",
        "controller" => "users",
        "action" => "profile"
    ],
    [
        "pattern" => "settings",
        "controller" => "users",
        "action" => "settings"
    ],
    [
        "pattern" => "unfriend/?",
        "controller" => "users",
        "action" => "friend",
        "parameters" => ["id"]
    ],
    [
        "pattern" => "friend/?",
        "controller" => "users",
        "action" => "friend",
        "parameters" => ["id"]
    ],
    [
        "pattern" => "fonts/:id",
        "controller" => "files",
        "action" => "fonts"
    ],
    [
        "pattern" => "thumbnails/:id",
        "controller" => "files",
        "action" => "thumbnails"
    ]
 ];

// add defined routes
foreach ($routes as $route) {
    $router->addRoute(new Framework\Router\Route\Simple($route));
}

// unset globals
unset($routes);
?>
