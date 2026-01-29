<?php

class ECreditCard {
    
    private string $ownerFirstName;
    private string $ownerLastName;
    private string $number;
    private DateTime $expirationDate;
    private string $cvv;

    public function __construct(
        string $ownerFirstName,
        string $ownerLastName,
        string $number,
        string $expirationDate,
        string $cvv)
    {
        $this->ownerFirstName = $ownerFirstName;
        $this->ownerLastName = $ownerLastName;
        $this->number = $number;
        $this->expirationDate = new DateTime($expirationDate);
        $this->cvv = $cvv;
    }

    // 'set' and 'get' methods

    public function setOwnerFirstName(string $ownerFirstName) {
        $this->ownerFirstName = $ownerFirstName;
    }

    public function getOwnerFirstName() : string {
        return $this->ownerFirstName;
    }

    public function setOwnerLastName(string $ownerLastName) {
        $this->ownerLastName = $ownerLastName;
    }

    public function getOwnerLastName() : string {
        return $this->ownerLastName;
    }

    public function setNumber(string $number) {
        $this->number = $number;
    }

    public function getNumber() : string {
        return $this->number;
    }

    public function setExpirationDate(string $expirationDate) {
        $this->expirationDate = new DateTime($expirationDate);
    }

    public function getExpirationDate() : DateTime {
        return $this->expirationDate;
    }

    public function setCVV(string $cvv) {
        $this->cvv = $cvv;
    }

    public function getCVV() : string {
        return $this->cvv;
    }
}

?>