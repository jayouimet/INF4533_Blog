<?php

class AuthProvider {
    static string $keyID = "auth";

    public static function login($obj) : bool {
        if($_SESSION[AuthProvider::$keyID] == ""){
            $_SESSION[AuthProvider::$keyID] = $obj;
            return true;
        } else {
            return false;
        }
    }

    public static function logout() : bool {
        if($_SESSION[AuthProvider::$keyID] != ""){
            $_SESSION[AuthProvider::$keyID] = "";
            return true;
        } else {
            return false;
        }
    }

    public static function getSessionObject() {
        if(!isset($_SESSION[AuthProvider::$keyID])) return "";
        
        return $_SESSION[AuthProvider::$keyID];
    }
}

?>