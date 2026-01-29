<?php

class EAdmin extends EUser {
    
    public function __construct(
        string $firstName, 
        string $lastName,                 
        string $email, 
        string $password) 
    {
        parent::__construct($firstName, $lastName, $email, $password);
    }
}

?>