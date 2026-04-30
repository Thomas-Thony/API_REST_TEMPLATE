<?php

class Database {
    public static function connect() : PDO {
        $host = $_ENV["DATABASE_HOST"];
        $port = $_ENV["DATABASE_PORT"];
        $dbname = $_ENV["DATABASE_NAME"];
        $user_name = $_ENV["DATABASE_USERNAME"];
        $password = $_ENV["DATABASE_PASSWORD"];
        try {
            $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8; port=$port", $user_name, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        } catch (PDOException $e) {
            die("Error by login to database : " . $e->getMessage());
        }
    }
}