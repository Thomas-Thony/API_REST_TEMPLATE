<?php

require_once "./Controllers/auth.php";

use ApiTemplate\Controllers\AuthController;
use ApiTemplate\Handlers\ApiHandler;

function login(PDO $pdo, array $data) : string | bool{
    if(!isset($data["mail"]) || !isset($data["password"])){
        return ApiHandler::getMissingFields();
    } else {
        $mail = $data["mail"];
        $password = $data["password"];
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        return AuthController::login($pdo, $mail, $hashedPassword);
    }
}

function register(PDO $pdo, array $data) : string | bool {
    if(!isset($data["username"]) || !isset($data["name"]) || !isset($data["mail"]) || !isset($data["password"])){
        return ApiHandler::getMissingFields();
    } else {
        $username = $data["username"];
        $name = $data["name"];
        $mail= $data["mail"];
        $password = $data["password"];
        $hashPassword = password_hash($password, PASSWORD_DEFAULT);
        
        return AuthController::register($pdo, $username, $name, $mail, $hashPassword, $password);
    }
}

function logout(PDO $pdo){
    return AuthController::logout($pdo);
}