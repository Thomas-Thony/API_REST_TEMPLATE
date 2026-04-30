<?php

namespace ApiTemplate\Controllers;
require_once "./Handlers/Globals.php";
require_once "./Handlers/tokenHandler.php";
use ApiTemplate\Handlers\ApiHandler;
use ApiTemplate\Handlers\Globals;
use ApiTemplate\Handlers\TokenHandler;
use ApiTemplate\Models\AuthModel;
use Firebase\JWT\JWT;

use Exception;
use PDO;

require_once "./Models/auth.php";

class AuthController {
    public static function login(PDO $pdo, string $mail, string $password) : string|bool {
        
        $user = AuthModel::tryLogin($pdo, $mail);
        if (empty($user) === true) {
            return ApiHandler::authentificationFailed("Mail or password incorrect");
        } else {
            $userPassword = $user["password"];
            if(password_verify($password, $userPassword) === true){
                $userInfos = AuthModel::login($pdo, $mail);
                $payload = [
                    "user_id" => $userInfos["id"],
                    "exp" => time() + 3600, // Expire in 1 hour
                ];
                $global = new Globals();
                $jwt = JWT::encode($payload, $global->getJwtEncodeKey(), "HS256");
                return json_encode(["token" => $jwt]);
            } else {
                return ApiHandler::authentificationFailed("Mail or password incorrect 2 hashed ");
            }
        }
    }

    public static function register(PDO $pdo, string $username, string $name, string $mail, string $passwordHashed, string $naturalPassword): string|bool {
        if(self::userExist($pdo, $mail) !== true){
            return AuthModel::getRegister($pdo,  $username, $name, $mail, $passwordHashed, $naturalPassword);
        } else {
            return json_encode("This user already exist !");
        }
    }

    public static function logout(PDO $pdo) {
        $decodeToken = TokenHandler::checkJWT($pdo);
        $headers = getallheaders();
        $authHeader = $headers['Authorization'] ?? $headers['authorization'] ?? '';
        $token = str_replace('Bearer ', '', $authHeader);

        try {
            $stmt = $pdo->prepare("INSERT INTO jwt_blacklist (token, user_id, expires_at) VALUES (:token, :userid, :expires_at)");
            $stmt->execute([
                ':token' => $token,
                ':userid' => $decodeToken->user_id,
                ':expires_at' => date('Y-m-d H:i:s', $decodeToken->exp)
            ]);

            return json_encode(["success" => true, "message" => "Logout with succes !"]);

        } catch (Exception $e) {
            http_response_code(500);
            return json_encode(["error" => "Error while login out", "Informations" => $e->getMessage()]);
        }
    }

    public static function userExist(PDO $pdo, string $mail) : bool {
        $user = AuthModel::tryLogin($pdo, $mail);
        return !empty($user);
    }
}