<?php

/**
 * Class for accessing the $_COOKIE superglobal array
 * 
 * This class provides methods for verifying the existence of a cookie key in and
 * retrieving a cookie value from the $_COOKIE superglobal array
 */
class UCookie {

    /**
     * Checks whether a cookie with a given key was sent by the http client
     * 
     * @param $key The key of the cookie to check the existence of
     * @return bool true if the cookie was sent in the http request, false otherwise
     */
    public static function isCookieSet($key) : bool {
        return isset($_COOKIE[$key]);
    }

    /**
     * Retrieves the content of a cookie with the specified key
     */
    public static function getCookieValue($key) {
        return $_COOKIE[$key];
    }
}
?>