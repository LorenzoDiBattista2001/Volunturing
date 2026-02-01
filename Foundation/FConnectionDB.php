<?php

class FConnectionDB {
    
    private static $instance;
    private $dbh;

    private function __construct() {
        try {
            $this->dbh = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASSWORD);
        } catch(PDOException $e) {
            print('ERROR: ' . $e->getMessage());
            exit;
        }
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

    public function getLastInsertId(?string $name = null) {
        $this->dbh->lastInsertId($name);
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