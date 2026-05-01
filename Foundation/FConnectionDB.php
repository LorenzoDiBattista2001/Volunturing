<?php

class FConnectionDB {
    
    private static $instance;
    private $dbh;

    /**
     * Initializes the database handle to a PDO object
     */
    private function __construct() {
        $this->dbh = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASSWORD);
        $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    /**
     * Instantiates or fetches the singleton object of this class
     * 
     * @return \FConnectionDB The singleton instance of this class
     */
    public static function getInstance() : FConnectionDB {
        if(!isset(self::$instance)) {
            self::$instance = new FConnectionDB();
        }
        return self::$instance;
    }

    /**
     * Prepares and sends a SQL query for execution by the DBMS and fetches the result
     */
    public function handleQuery(string $query, ?array $params = null) {
        $stmt = $this->dbh->prepare($query);
        $stmt->execute($params);
        return $stmt;
    } 

    /**
     * Returns the ID of the last inserted row or sequence value
     */
    public function getLastInsertId(?string $name = null) : int {
        return $this->dbh->lastInsertId($name);
    }

    /**
     * Initiates a transaction
     */
    public function beginTransaction() {
        $this->dbh->beginTransaction();
    }

    /**
     * Commits a transaction
     */
    public function commit() {
        $this->dbh->commit();
    }

    /**
     * Rolls back a transaction
     */
    public function rollBack() {
        $this->dbh->rollBack();
    }
}

?>