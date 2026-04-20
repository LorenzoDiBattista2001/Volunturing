<?php

class FConnectionDB {
    
    private static $instance;
    private $dbh;

    private function __construct() {
        $this->dbh = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASSWORD);
        $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public static function getInstance() : FConnectionDB {
        if(!isset(self::$instance)) {
            self::$instance = new FConnectionDB();
        }
        return self::$instance;
    }

    public function handleQuery(string $query, ?array $params = null) {
        $stmt = $this->dbh->prepare($query);
        $stmt->execute($params);
        return $stmt;
    } 

    public function getLastInsertId(?string $name = null) : int {
        return $this->dbh->lastInsertId($name);
    }

    public function beginTransaction() {
        $this->dbh->beginTransaction();
    }

    public function commit() {
        $this->dbh->commit();
    }

    public function rollBack() {
        $this->dbh->rollBack();
    }
}

?>