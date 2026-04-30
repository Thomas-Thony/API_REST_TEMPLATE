<?php #### Main file for inclusions (avoid circular dependencies)

#### Dependecies
require_once "./vendor/autoload.php";

#### Headers and CORS

#### Web app
require_once "./Web/main.php";
require_once "./Web/auth.php";

#### Handlers for API
require_once "./Handlers/ApiHandler.php";
require_once "./Handlers/HeadersHandler.php";
require_once "./Handlers/HttpHandler.php";

#### Others
require_once "./Database/Database.php";