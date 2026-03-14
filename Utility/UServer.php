<?php

class UServer {

    public static function getRequestMethod() {
        return $_SERVER['REQUEST_METHOD'];
    }

    public static function getRequestURI() {
        return $_SERVER['REQUEST_URI'];
    }
}
?>