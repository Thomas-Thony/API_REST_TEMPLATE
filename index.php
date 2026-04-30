<?php
// Get the file with all inclusions (a bit like the header file in c++)
require_once "./requirements.php";

use ApiTemplate\Handlers\ApiHandler;
use ApiTemplate\Handlers\HeaderHttpHandler;

// Set headers for HTTP/HTTPS requests
$headers = new HeaderHttpHandler(1);
use Dotenv\Dotenv;

// Manage OPTIONS requests (preflight)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

$method = $_SERVER['REQUEST_METHOD']; //We get the HTTP/HTTPS method sent by the client
$path = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
$segments = explode('/', $path);

$dotenv = Dotenv::createImmutable("./"); // Indicate where the .env is located
$dotenv->load(); // Necessary to get env values

$pdo = Database::connect(); //PDO object to login database
$apiMessage = new ApiHandler(); // Management of API messages in case of error
$resultat = null; //Default value printed by API

if (isset($segments[1])) {
    $mainPath = $segments[1] ?? null; // URL value
    $subPath = $segments[2] ?? null; // URL value
    $subSubPath = $segments[3] ?? null; // URL value

    #region Authentification management
    if ($mainPath === "login" && $method === "POST") {
        $data = json_decode(file_get_contents('php://input'), true);
        $resultat = login($pdo, $data);
    }

    if ($mainPath === "register" && $method === "POST") {
        $data = json_decode(file_get_contents('php://input'), true);
        $resultat = register($pdo, $data);
    }

    if ($mainPath === "logout" && $method === "POST") {
        $data = json_decode(file_get_contents('php://input'), true);
        $resultat = logout($pdo);
    }

    /* TODO : 'Fix Uncaught Error: Object of class stdClass could not be converted to string' 
    if($mainPath === "decode" && $method === "POST") {
        $data = json_decode(file_get_contents('php://input'), true);
        $resultat = TokenHandler::checkJWT($pdo);
    }
    */ 
    #endregion

    #region Others routes
    if($mainPath === "doc" && $method === "GET"){
        $resultat = doc();
    }
    #endregion
}

#region IMPORTANT: Manage when no routes matches
if ($resultat === null) {
    // If the is no path
    if (isset($mainPath)) {
        $resultat = notFound();
    } else {
        // If we are on the main route (root route '/')
        $resultat = itWorks();
    }
}
#endregion
echo $resultat;