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
        $this->setNumber($number);
        $this->setExpirationDate($expirationDate);
        $this->setCVV($cvv);
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
        if(!$this->validateNumber($number)) {
            throw new Exception('Card number is not in a valid format');
        }
        $this->number = $number;
    }

    public function getNumber() : string {
        return $this->number;
    }

    public function setExpirationDate(string $expirationDate) {
        if(!$this->validateExpirationDate($expirationDate)) {
            throw new Exception('Credit card is expired or expiration date is not in a valid format');
        }
        $this->expirationDate = (DateTime::createFromFormat('d-m-y', str_replace('/', '-', '01-' . $expirationDate))->modify('last day of this month'));
    }

    public function getExpirationDate() : DateTime {
        return $this->expirationDate;
    }

    public function setCVV(string $cvv) {
        if(!$this->validateCVV($cvv)) {
            throw new Exception('CVV is not in a valid format');
        }
        $this->cvv = $cvv;
    }

    public function getCVV() : string {
        return $this->cvv;
    }

    // card validation methods

    public function validateExpirationDate(string $expirationDate) : bool {
        $pattern = '/^(0[1-9]|1[0-2])\/([0-9]{2})$/';
        if(!preg_match($pattern, $expirationDate)) {
            return false;
        }

        $expirationDateObject = DateTime::createFromFormat('d-m-y', '01-' . str_replace('/', '-', $expirationDate));
        if(!$expirationDateObject) {
            return false;
        }

        $expirationDateObject->modify('last day of this month');
        $currentDate = new DateTime('today');

        return $expirationDateObject >= $currentDate;
    }

    public function validateNumber(string $number) : bool {
        $pattern = '/^[0-9]{16}$/';
        return preg_match($pattern, $number);
    }

    public function validateCVV(string $cvv) : bool {
        $pattern = '/^[0-9]{3}$/';
        return preg_match($pattern, $cvv);
    }

    // payment method

    public function performPayment(EDonation $donation) : bool {
        return true;
    }
}

?>