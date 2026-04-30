<?php

namespace ApiTemplate\Handlers;
use Dotenv\Dotenv;

class Globals {
    private string $jwtEncodeKey;

    public function __construct(){
        $dotenv = Dotenv::createImmutable("./"); //Indique ou se trouve le fichier d'environnement
        $dotenv->load(); // Indispensable pour récupérer les valeurs

        $this->jwtEncodeKey = $_ENV["JWT_ENCRYPTION_KEY"];
    }

    public function getJwtEncodeKey() : string {
        return $this->jwtEncodeKey;
    }
}