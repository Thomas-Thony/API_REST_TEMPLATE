<?php

namespace ApiTemplate\Handlers;

class HttpHandler {
    public function __construct() {

    }
    public function sendResponse(int $httpcode, string $message) : string | bool {
        http_response_code($httpcode);
        return json_encode([
            "HTTP CODE " => $httpcode,
            "HTTP ERROR" => $message
            ]);
    }
}