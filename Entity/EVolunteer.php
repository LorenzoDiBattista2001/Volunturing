<?php

class EVolunteer extends EUser {

    private DateTime $birthDate;
    private string $birthPlace;
    private string $taxCode;
    private string $telephoneNumber;
    private string $streetAddress;
    private string $houseNumber;
    private ?string $description;
    private bool $isBlocked;
    private array $applications;
    private array $donations;
    private array $reviews;

    public function __construct(
        string $firstName, 
        string $lastName, 
        string $email, 
        string $password,
        string $birthDate, 
        string $birthPlace, 
        string $taxCode, 
        string $telephoneNumber,
        string $streetAddress, 
        string $houseNumber, 
        bool $isBlocked) 
    {
        parent::__construct($firstName, $lastName, $email, $password);
        $this->birthDate = new DateTime($birthDate);
        $this->birthPlace = $birthPlace;
        $this->taxCode = $taxCode;
        $this->telephoneNumber = $telephoneNumber;
        $this->streetAddress = $streetAddress;
        $this->houseNumber = $houseNumber;
        $this->isBlocked = $isBlocked;
        $this->applications = array();
        $this->donations = array();
        $this->reviews = array();
    }
}

?>