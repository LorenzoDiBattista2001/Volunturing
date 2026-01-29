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
}

?>