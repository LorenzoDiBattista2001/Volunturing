<?php

class EUser {
    
    private int $userId;
    private string $firstName;
    private string $lastName;
    private string $email;
    private string $password;

    public function __construct(
        string $firstName, 
        string $lastName,
        string $email, 
        string $password) 
    {
        $this->setFirstName($firstName);
        $this->setLastName($lastName);
        $this->setEmail($email);
        $this->setPassword($password);
    }

    // 'set' and 'get' methods

    public function setUserId(int $userId) {
        $this->userId = $userId;
    }

    public function getUserId() : int {
        return $this->userId;
    }

    public function setFirstName(string $firstName) {
        if(!isset($firstName) || $firstName === '') {
            throw new Exception('Nessun nome inserito');
        }
        $this->firstName = $firstName;
    }

    public function getFirstName() : string {
        return $this->firstName;
    }

    public function setLastName(string $lastName) {
        if(!isset($lastName) || $lastName === '') {
            throw new Exception('Nessun cognome inserito');
        }
        $this->lastName = $lastName;
    }

    public function getLastName() : string {
        return $this->lastName;
    }

    public function setEmail(string $email) {
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception('Inserisci un indirizzo email valido');
        }
        $this->email = $email;
    }

    public function getEmail() : string {
        return $this->email;
    }

    public function setPassword(string $password) {
        if(strlen($password) < 8) {
            throw new Exception('La password deve avere una lunghezza minima di 8 caratteri');
        }
        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }

    public function setHashedPassword(string $hashedPasswordFromDatabase) {
        $this->password = $hashedPasswordFromDatabase;
    }

    public function getPassword() : string {
        return $this->password;
    }
}

?>