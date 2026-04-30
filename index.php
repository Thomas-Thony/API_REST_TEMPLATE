<?php
// Récupère le fichier avec toutes les inclusions (équivalent au header dans un fichier c++)
require_once "./requirements.php";

use ApiTemplate\Handlers\ApiHandler;
use ApiTemplate\Handlers\HeaderHttpHandler;

// Set headers for HTTP/HTTPS requests
$headers = new HeaderHttpHandler(1);
use Dotenv\Dotenv;

// Gérer les requêtes OPTIONS (preflight)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

$method = $_SERVER['REQUEST_METHOD']; //On récupère la méthode envoyée par le client
$path = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
$segments = explode('/', $path);

//On récupère les variables d'environnement avec le chemin relatif jusqu'au fichier (sans le nom ni l'extension de ce derner, la librairie se charge du reste)
$dotenv = Dotenv::createImmutable("./"); //Indique ou se trouve le fichier d'environnement
$dotenv->load(); // Indispensable pour récupérer les valeurs

$pdo = Database::connect(); //PDO object to login database
$apiMessage = new ApiHandler(); //Gestionnaire de messages de l'API en cas d'erreurs
$resultat = null; //Default value printed by API

if (isset($segments[1])) {
    $mainPath = $segments[1] ?? null; // Valeur de l'url
    $subPath = $segments[2] ?? null; // Valeur de l'url
    $subSubPath = $segments[3] ?? null; // Valeur de l'url

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