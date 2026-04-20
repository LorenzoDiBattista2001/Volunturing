<?php

class UServer {

    public static function getRequestMethod() {
        return $_SERVER['REQUEST_METHOD'];
    }

    public static function getRequestURI() {
        return $_SERVER['REQUEST_URI'];
    }

    public static function getEntryByKey(string $key) {
        if(isset($_SERVER[$key])) {
            return $_SERVER[$key];
        }
    }
}
?>