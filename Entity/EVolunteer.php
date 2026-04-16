<?php

class EVolunteer extends EUser {

    private DateTime $birthDate;
    private string $birthPlace;
    private string $taxCode;
    private string $telephoneNumber;
    private string $streetAddress;
    private string $houseNumber;
    private ?string $description = null;
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
        $this->setBirthDate($birthDate);
        $this->birthPlace = $birthPlace;
        $this->taxCode = $taxCode;
        $this->telephoneNumber = $telephoneNumber;
        $this->setStreetAddress($streetAddress);
        $this->setHouseNumber($houseNumber);
        $this->isBlocked = $isBlocked;
        $this->applications = array();
        $this->donations = array();
        $this->reviews = array();
    }

    // 'set' and 'get' methods

    public function setBirthDate(string $birthDate) {
        $pattern = '/^(19|20)[0-9]{2}-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01])$/';
        if(!preg_match($pattern, $birthDate)) {
            throw new Exception('La data inserita non è in un formato valido');
        }

        $parts = explode('-', $birthDate);
        if (!checkdate($parts[1], $parts[2], $parts[0])) {
            throw new Exception('La data inserita non è logicamente corretta');
        }

        $dateObject = new DateTime($birthDate);
        $now = new DateTime('today');
        $interval = $dateObject->diff($now);

        if($interval->y < 18) {
            throw new Exception('Per potersi registrare è necessario essere maggiorenni');
        }
        $this->birthDate = $dateObject;
    }

    public function getBirthDate() : DateTime {
        return $this->birthDate;
    }

    public function setBirthPlace(string $birthPlace) {
        $this->birthPlace = $birthPlace;
    }

    public function getBirthPlace() : string {
        return $this->birthPlace;
    }

    public function setTaxCode(string $taxCode) {
        $this->taxCode = $taxCode;
    }

    public function getTaxCode() : string {
        return $this->taxCode;
    }

    public function setTelephoneNumber(string $telephoneNumber) {
        $this->telephoneNumber = $telephoneNumber;
    }

    public function getTelephoneNumber() : string {
        return $this->telephoneNumber;
    }

    public function setStreetAddress(string $streetAddress) {
        if(!$this->validateStreetAddress($streetAddress)) {
            throw new Exception('Inserire un indirizzo valido');
        }
        $this->streetAddress = $streetAddress;
    }

    public function getStreetAddress() : string {
        return $this->streetAddress;
    }

    public function setHouseNumber(string $houseNumber) {
        $pattern = '/^[1-9][0-9]{0,2}$/';
        if(!preg_match($pattern, $houseNumber)) {
            throw new Exception('Il numero civico inserito non è valido');
        }
        $this->houseNumber = $houseNumber;
    }

    public function getHouseNumber() : string {
        return $this->houseNumber;
    }

    public function setDescription(?string $description) {
        $this->description = $description;
    }

    public function getDescription() : ?string {
        return $this->description;
    }

    public function block() {
        if($this->isBlocked()) {
            throw new Exception('User is already blocked');
        }
        $this->isBlocked = true;
    }

    public function unlock() {
        if(!$this->isBlocked()) {
            throw new Exception('User is already unlocked');
        }
        $this->isBlocked = false;
    }

    public function isBlocked() : bool {
        return $this->isBlocked;
    }

    // methods for managing user's applications

    public function setApplications(array $applications) {
        $this->applications = $applications;
    }

    public function getApplications() {
        return $this->applications;
    }

    public function addApplication(EApplication $application) {
        $this->applications[] = $application;
    }

    // methods for manipulating user's reviews

    public function setReviews(array $reviews) {
        $this->reviews = $reviews;
    }

    public function getReviews() {
        return $this->reviews;
    }

    public function addReview(EReview $review) {
        $this->reviews[] = $review;
    }

    // methods for manipulating user's donations

    public function setDonations(array $donations) {
        $this->donations = $donations;
    }

    public function getDonations() {
        return $this->donations;
    }

    public function addDonation(EDonation $donation) {
        $this->donations[] = $donation;
    }

    // user data validation methods

    public function validateStreetAddress(string $streetAddress) : bool {
        $streetAddress = trim($streetAddress);
        if(strlen($streetAddress) < 6) {
            return false;
        }
        if(!strpos($streetAddress, ' ')) {
            return false;
        }
        if(preg_match('/^[0-9]*$/', $streetAddress)) {
            return false;
        }
        return true;
    }
    
    // additional methods

    public function calculateAge() : int {
        $now = new DateTime('now');
        $interval = $this->birthDate->diff($now);

        return $interval->format('%Y');
    }

    public function getInitials() : string {
        return strtoupper($this->getFirstName()[0] . $this->getLastName()[0]);
    }
}

?>