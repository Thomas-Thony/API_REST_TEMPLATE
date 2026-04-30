<?php

use ApiTemplate\Handlers\HttpHandler;

function itWorks(){
    return json_encode("It works !");
}

function notFound(){
    $httpHandler = new HttpHandler();
    return $httpHandler->sendResponse(404, "Not found !");
}