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
}

?>