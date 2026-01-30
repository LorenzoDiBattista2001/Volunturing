<?php

class FPersistentManager {

    private static $instance;

    private function __construct() {

    }

    public static function getInstance() : FPersistentManager {
        if(!isset(self::$instance)) {
            self::$instance = new FPersistentManager();
        }
        return self::$instance;
    }

}

?>