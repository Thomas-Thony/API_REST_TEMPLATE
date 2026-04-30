<?php

namespace ApiTemplate\Models;

use ApiTemplate\Controllers\AuthController;
use PDO;
use Exception;

class AuthModel {
    public static function tryLogin(PDO $pdo, string $mail): mixed {
        $stmt = $pdo->prepare("SELECT mail, password FROM users WHERE mail = :mail");
        $stmt->bindParam(":mail", $mail, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function login(PDO $pdo, string $mail) : mixed {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE mail = :mail");
        $stmt->bindParam(":mail", $mail, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function getRegister(PDO $pdo, string $username, string $name, string $mail, string $passwordHashed, string $naturalPassword): string|bool {
        $actualDate = date("Y-m-d");
        try {
            $stmt = $pdo->prepare("INSERT INTO users (username, name, mail, password, created) VALUES (:username, :name, :mail, :password, :created);");
            $stmt->bindParam(":username", $username, PDO::PARAM_STR);
            $stmt->bindParam(":name", $name, PDO::PARAM_STR);
            $stmt->bindParam(":mail", $mail, PDO::PARAM_STR);
            $stmt->bindParam(":password", $passwordHashed, PDO::PARAM_STR);
            $stmt->bindParam(":created", $actualDate, PDO::PARAM_STR);
            $stmt->execute();

            return AuthController::login($pdo, $mail, $naturalPassword);

        } catch (Exception $e) {
            return json_encode([$e->getMessage()]);
        }
    }
}