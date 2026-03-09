<?php

class UServer {

    private static function getRequestMethod() {
        return $_SERVER['REQUEST_METHOD'];
    }

    private static function getRequestUri() {
        return $_SERVER['REQUEST_URI'];
    }
}
?>