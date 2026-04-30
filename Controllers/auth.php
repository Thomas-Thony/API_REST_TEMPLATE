<?php

namespace ApiTemplate\Controllers;
use ApiTemplate\Models\AuthModel;
use ApiTemplate\Handlers\ApiHandler;
use ApiTemplate\Handlers\Globals;
use Firebase\JWT\JWT;
use PDO;

require_once "./Models/auth.php";

class AuthController {
    public static function login(PDO $pdo, string $mail, string $password) : string|bool {
        
        $user = AuthModel::tryLogin($pdo, $mail);
        if (empty($user) === true) {
            return json_encode("Login failed !");
        } else {
            $userPassword = $user["password"];
            if(password_verify($userPassword, $password) === true){
                $userInfos = AuthModel::login($pdo, $mail);
                $payload = [
                    "user_id" => $userInfos["id"],
                    "exp" => time() + 3600, // Expire in 1 hour
                ];
                $global = new Globals();
                $jwt = JWT::encode($payload, $global->getJwtEncodeKey(), "HS256");
                return json_encode(["token" => $jwt]);
            } else {
                return ApiHandler::authentificationFailed("Login failed !");
            }
        }
    }

    public static function register(PDO $pdo, string $username, string $name, string $mail, string $password): bool {
        return AuthModel::getRegister($pdo,  $username, $name, $mail, $password);
    }

    public static function logout(): bool {
        return true;
    }
}