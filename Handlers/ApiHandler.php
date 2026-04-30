<?php

namespace ApiTemplate\Handlers;

class ApiHandler {
    public function __construct() {

    }

    public static function getMissingFields(){
        return json_encode(["Error : " => "Missing one or more fields"]);
    }

    public static function authentificationFailed(string $reason){
        return json_encode(["Error while login or register : " => $reason]);
    }
}