<?php

/**
 * Class for handling PHP sessions and for accessing the $_SESSION superglobal array
 */
class USession {

    /**
     * The singleton instance of this class
     */
    private static $instance;

    /**
     * Initializes session parameters and starts the session
     */
    private function __construct() {
        ini_set('session.gc_maxlifetime', GC_MAX_LIFETIME);
        session_set_cookie_params(SESSION_COOKIE_LIFETIME, secure: true, httponly: true);
        session_start();
    }

    /**
     * Fetches the singleton instance of this class
     * 
     * @return \USession The singleton object to get the handle of
     */
    public static function getInstance() : USession {
        if(!isset(self::$instance)) {
            self::$instance = new USession();
        }
        return self::$instance;
    }

    /**
     * Declares a session variable and sets it to a given value
     * 
     * @param $key The session variable name
     * @param $value The value to be assigned to the session variable
     */
    public function setSessionElement($key, $value) {
        $_SESSION[$key] = $value;
    }

    /**
     * Unsets a session variable
     * 
     * @param $key The session variable name
     */
    public function unsetSessionElement($key) {
        unset($_SESSION[$key]);
    }

    /**
     * Retrieves the value of a given session variable
     * 
     * @param $key The session variable name
     */
    public function getSessionElement($key) {
        return $_SESSION[$key];
    }

    /**
     * Checks whether a given session variable is set
     * 
     * @param $key The session variable name
     * @return bool true if the session variable with the specified name is set to a value other than null, false otherwise
     */
    public function isElementSet($key) : bool {
        return isset($_SESSION[$key]);
    }

    /**
     * Returns the current session status
     */
    public function getSessionStatus() {
        return session_status();
    }

    /**
     * Frees all session variables
     */
    public function unsetSessionVariables() {
        session_unset();
    }

    /**
     * Destroys all data registered to a session
     */
    public function destroySession() {
        session_destroy();
    }
}
?>