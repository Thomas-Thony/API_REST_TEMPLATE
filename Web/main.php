<?php

use ApiTemplate\Handlers\HttpHandler;

function itWorks(){
    // TODO : Create Swagger UI documentation
    return json_encode([
        "Try to login" => "/login (in POST)",
        "Try to register" => "/register (in POST)",
        "Try to logout" => "/logout (in POST)",
        "See documentation" => "/doc"
    ]);
}

function notFound(){
    $httpHandler = new HttpHandler();
    return $httpHandler->sendResponse(404, "Not found !");
}

/**
 * Return the datas for Swagger UI documentation
 * @return string|bool
 */
function doc() : string|bool{
    return json_encode([
        "success" => true,
        "documentation" => $_ENV['SWAGGER_URL']
    ]);
}