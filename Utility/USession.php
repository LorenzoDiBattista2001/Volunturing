<?php

class USession {

    private static $instance;

    private function __construct() {
        ini_set('session.gc_maxlifetime', GC_MAX_LIFETIME);
        session_set_cookie_params(SESSION_COOKIE_LIFETIME, secure: true, httponly: true);
        session_start();
    }

    public static function getInstance() : USession {
        if(!isset(self::$instance)) {
            self::$instance = new USession();
        }
        return self::$instance;
    }

    public static function setSessionElement($key, $value) {
        $_SESSION[$key] = $value;
    }

    public static function getSessionElement($key) {
        return $_SESSION[$key];
    }

    public static function isElementSet($key) : bool {
        return isset($_SESSION[$key]);
    }

    public static function getSessionStatus() {
        return session_status();
    }

    public static function unsetSessionVariables() {
        session_unset();
    }

    public static function destroySession() {
        session_destroy();
    }
}
?>