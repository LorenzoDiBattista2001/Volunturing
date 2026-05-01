<?php

/**
 * Class for accessing the $_SERVER superglobal array
 * 
 * This class provides methods for accessing elements of the $_SERVER
 * superglobal array by a given key
 */
class UServer {

    /**
     * Retrieves the method of the http request sent by the http client
     */
    public static function getRequestMethod() {
        return $_SERVER['REQUEST_METHOD'];
    }

    /**
     * Retrieves the URI requested by the http client
     */
    public static function getRequestURI() {
        return $_SERVER['REQUEST_URI'];
    }

    /**
     * Retrieves the element of the $_SERVER superglobal array with the specified key, if it is set
     */
    public static function getEntryByKey(string $key) {
        if(isset($_SERVER[$key])) {
            return $_SERVER[$key];
        }
    }
}
?>