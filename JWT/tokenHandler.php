<?php

use ApiTemplate\Handlers\Globals;

require_once "./vendor/autoload.php";

require_once __DIR__ . '/JWT/JWT.php';
require_once __DIR__ . '/JWT/Key.php';
require_once __DIR__ . "/../Handlers/Globals.php";

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

#region Vérification du jeton
function decodeToken(array $data): string {
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
 * @return stdClass|null
 */
function checkJWT(): ?stdClass {
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
        return JWT::decode($token, new Key($globals->getJwtEncodeKey(), 'HS256'));
    } catch (Exception $e) {
        http_response_code(401);
        echo json_encode(["error" => "Token invalide", "Informations" => $e->getMessage()]);
        exit;
    }
}

#endregion