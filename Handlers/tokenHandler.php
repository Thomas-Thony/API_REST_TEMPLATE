<?php

namespace ApiTemplate\Handlers;
use ApiTemplate\Handlers\Globals;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Exception;
use PDO;

require_once "./vendor/autoload.php";

require_once './JWT/JWT.php';
require_once './JWT/Key.php';
require_once "./Handlers/Globals.php";


class TokenHandler {
    #region Vérification du jeton
    public static function decodeToken(array $data): string {
        if (!isset($data['token'])) {
            return json_encode(["error" => "Token manquant"]);
        }
        $token = $data['token'];
        try {
            $globals = new Globals();
            $decoded = JWT::decode($token, new Key($globals->getJwtEncodeKey(), 'HS256'));
            return json_encode(["valid" => true, "data" => $decoded]);
        } catch (Exception $e) {
            return json_encode(["valid" => false, "error" => $e->getMessage()]);
        }
    }

    /**
     * Vérification de la validité d'un token JWT transmis dans l'en-tête Authorization
     *
     * @return \stdClass|null
     */
    public static function checkJWT(PDO $pdo): ?\stdClass {
        $headers = getallheaders();
        $authHeader = $headers['Authorization'] ?? $headers['authorization'] ?? null;
        if (!$authHeader) {
            http_response_code(401);
            echo json_encode(["error" => "Token manquant"]);
            exit;
        }
        $token = str_replace('Bearer ', '', $authHeader);
        try {
            $globals = new Globals();
            $decoded = JWT::decode($token, new Key($globals->getJwtEncodeKey(), 'HS256'));
            if (self::isTokenBlacklisted($pdo, $token)) {
                http_response_code(401);
                echo json_encode(["error" => "Token invalide", "Informations" => "Token révoqué"]);
                exit;
            }
            return $decoded;
        } catch (Exception $e) {
            http_response_code(401);
            echo json_encode(["error" => "Token invalide", "Informations" => $e->getMessage()]);
            exit;
        }
    }

    public static function isTokenBlacklisted(PDO $pdo, string $token): bool {
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM jwt_blacklist WHERE token = :token AND expires_at > NOW()");
        $stmt->execute([':token' => $token]);
        return $stmt->fetchColumn() > 0;
    }
    #endregion
}