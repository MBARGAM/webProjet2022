<?php
namespace App\Classes;

/**
 * string
 * @throws \Exception
 */
class TokenCreation {
    public function generateToken() {
        $token = rtrim(strtr(base64_encode(random_bytes(32)), '+/', '-_'), '=');//rtrim supprime les caractères de fin de chaine
        return $token;
    }
}

?>