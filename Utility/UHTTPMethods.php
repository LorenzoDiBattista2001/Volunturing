<?php

/**
 * Class for accessing the $_POST and $_GET superglobal arrays
 * 
 * This class provides methods for accessing elements of $_POST and $_GET
 * superglobal arrays by a given key
 */
class UHTTPMethods {

     /**
     * Retrieves the element in the $_POST superglobal array with the specified key, if it is set
     */
    public static function post($key) {
        if(isset($_POST[$key])) {
            return $_POST[$key];
        }
    }

    /**
     * Retrieves the element in the $_GET superglobal array with the specified key, if it is set
     */
    public static function get($key) {
        if(isset($_GET[$key])) {
            return $_GET[$key];
        }
    }
}
?>