<?php

/**
 * The AuthProvider class is a Helper class to help the login & logout process of an app.
 */
class AuthProvider {
    /* The key in the session to get the user */
    static string $keyID = "auth";

    /**
     * Function to login using an item.
     *
     * @param mixed $obj   The user or object to store in $_SESSION[$keyID].
     * @return boolean      Returns true if the login process was successful, false otherwise.
     */
    public static function login($obj) : bool {
        if(!isset($_SESSION[AuthProvider::$keyID])){
            $_SESSION[AuthProvider::$keyID] = $obj;
            return true;
        } else {
            return false;
        }
    }

    /**
     * Function to logout. Check if there's something in $_SESSION[$keyID].
     *
     * @return boolean  Returns true if the logout process was successful, false otherwise.
     */
    public static function logout() : bool {
        if(isset($_SESSION[AuthProvider::$keyID])){
            unset($_SESSION[AuthProvider::$keyID]);
            return true;
        } else {
            return false;
        }
    }

    /**
     * Function to get the object stored at $_SESSION[$keyID].
     *
     * @return mixed    Returns an object.
     */
    public static function getSessionObject() {
        if(!isset($_SESSION[AuthProvider::$keyID])) return "";
        
        return $_SESSION[AuthProvider::$keyID];
    }
}

?>