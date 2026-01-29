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
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->password = $password;
    }

    // 'set' and 'get' methods

    public function setUserId(int $userId) {
        $this->userId = $userId;
    }

    public function getUserId() : int {
        return $this->userId;
    }

    public function setFirstName(string $firstName) {
        $this->firstName = $firstName;
    }

    public function getFirstName() : string {
        return $this->firstName;
    }

    public function setLastName(string $lastName) {
        $this->lastName = $lastName;
    }

    public function getLastName() : string {
        return $this->lastName;
    }

    public function setEmail(string $email) {
        $this->email = $email;
    }

    public function getEmail() : string {
        return $this->email;
    }

    public function setPassword(string $password) {
        $this->password = $password;
    }

    public function getPassword() : string {
        return $this->password;
    }
}

?>