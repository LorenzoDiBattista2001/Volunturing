<?php

class UCookie {

    public static function isCookieSet($key) : bool {
        return isset($_COOKIE[$key]);
    }

    public static function getCookieValue($key) {
        return $_COOKIE[$key];
    }
}
?>