<?php

class EVolunteer extends EUser {

    private DateTime $birthDate;
    private string $birthPlace;
    private string $taxCode;
    private string $telephoneNumber;
    private string $streetAddress;
    private string $houseNumber;
    private string $description;
    private bool $isBlocked;
    private array $applications = array();
    private array $donations = array();
    private array $reviews = array();
}

?>