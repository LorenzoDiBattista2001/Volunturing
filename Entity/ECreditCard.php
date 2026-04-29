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

    /**
     * Sets the credit card number
     * 
     * @param string $number The credit card number inserted by the user
     * @throws Exception If the credit card number fails to validate
     */
    public function setNumber(string $number) {
        if(!$this->validateNumber($number)) {
            throw new Exception('Il numero di carta inserito non è in formato valido');
        }
        $this->number = $number;
    }

    public function getNumber() : string {
        return $this->number;
    }

    /**
     * Sets the credit card expiration date
     * 
     * @param string $expirationDate The credit card expiration date inserted by the user
     * @throws Exception If the credit card expiration date fails to validate
     */
    public function setExpirationDate(string $expirationDate) {
        if(!$this->validateExpirationDate($expirationDate)) {
            throw new Exception('La carta di credito è scaduta, oppure la data inserita non è in un formato valido (MM//YY)');
        }
        $this->expirationDate = (DateTime::createFromFormat('d-m-y', str_replace('/', '-', '01-' . $expirationDate))->modify('last day of this month'));
    }

    public function getExpirationDate() : DateTime {
        return $this->expirationDate;
    }

    /**
     * Sets the credit card cvv number
     * 
     * @param string $cvv The credit card cvv number inserted by the user
     * @throws Exception If the credit card cvv number fails to validate
     */
    public function setCVV(string $cvv) {
        if(!$this->validateCVV($cvv)) {
            throw new Exception('Il CVV inserito non è in formato valido');
        }
        $this->cvv = $cvv;
    }

    public function getCVV() : string {
        return $this->cvv;
    }

    // card validation methods

    /**
     * Validates the credit card expiration date
     * 
     * This method first assesses whether the credit card expiration
     * date was entered in the format 'MM/YY'. If the format is
     * correct, it tries to instantiate a DateTime object by artificially
     * setting the day to the first of the month's. Finally, is the DateTime
     * object was successfully created, the day is set to the last of the month's
     * (credit cards expires at the end of the month) and the expiration date
     * is compared with the current date.
     * 
     * @param string $expirationDate The credit card expiration date inserted by the user
     * @return bool True if the expiration date format is correct and the card is not expired, false otherwise
     */
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

    /**
     * Validates the credit card number
     * 
     * Returns true if the credit card number entered by
     * the user is made up of only digits and its length
     * is exactly sixteen characters, false otherwise.
     * 
     * @param string $number The string to be validated
     * @return bool
     */
    public function validateNumber(string $number) : bool {
        return (ctype_digit($number) && (strlen($number) === 16));
    }

    /**
     * Validates the CVV number
     * 
     * Returns true if the cvv entered by the user consists of
     * exactly three digits, false otherwise
     * 
     * @param string $cvv The string to be validated
     * @return bool
     */
    public function validateCVV(string $cvv) : bool {
        return (ctype_digit($cvv) && (strlen($cvv) === 3));
    }

    // payment logic

    /**
     * Performs the requested bank transaction
     * 
     * In a real-case scenario, this method would connect to a third-party
     * banking software or to the bank API. Here, the transaction is simulated
     * by always returning a boolean value of 'true', indicating the transaction
     * was successfully performed.
     * 
     * @param EDonation $donation The donation to be performed
     * @return bool
     */
    public function performPayment(EDonation $donation) : bool {
        return true;
    }
}

?>