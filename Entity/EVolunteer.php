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
        $this->setBirthPlace($birthPlace);
        $this->setTaxCode($taxCode);
        $this->setTelephoneNumber($telephoneNumber);
        $this->setStreetAddress($streetAddress);
        $this->setHouseNumber($houseNumber);
        $this->isBlocked = $isBlocked;
        $this->applications = array();
        $this->donations = array();
        $this->reviews = array();
    }

    // 'set' and 'get' methods

    public function setBirthDate(string $birthDate) {
        if(!$this->validateBirthDate($birthDate)) {
            throw new Exception('La data inserita non è in un formato valido');
        }

        $parts = explode('-', $birthDate);
        if (!checkdate($parts[1], $parts[2], $parts[0])) {
            throw new Exception('La data inserita non è logicamente corretta');
        }

        $dateObject = new DateTime($birthDate);
        $now = new DateTime('today');
        $interval = $dateObject->diff($now);

        if($dateObject > $now) {
            throw new Exception('La data inserita appartiene al futuro');
        }

        if($interval->y < 18) {
            throw new Exception('Per potersi registrare è necessario essere maggiorenni');
        }
        $this->birthDate = $dateObject;
    }

    public function getBirthDate() : DateTime {
        return $this->birthDate;
    }

    public function setBirthPlace(string $birthPlace) {
        if(!$this->validateBirthPlace($birthPlace)) {
            throw new Exception('Assicurarsi di aver riportato bene il luogo di nascita');
        }
        $this->birthPlace = $birthPlace;
    }

    public function getBirthPlace() : string {
        return $this->birthPlace;
    }

    public function setTaxCode(string $taxCode) {
        if(!$this->validateTaxCode($taxCode)) {
            throw new Exception('Inserire un codice fiscale valido');
        }
        $this->taxCode = $taxCode;
    }

    public function getTaxCode() : string {
        return $this->taxCode;
    }

    public function setTelephoneNumber(string $telephoneNumber) {
        if(!$this->validateTelephoneNumber($telephoneNumber)) {
            throw new Exception('Inserire un numero di telefono valido');
        }
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
        if(!$this->validateHouseNumber($houseNumber)) {
            throw new Exception('Inserire un numero civico valido');
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

    public function validateBirthDate(string $birthDate) : bool {
        $pattern = '/^(19|20)[0-9]{2}-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01])$/';
        return preg_match($pattern, $birthDate);
    }

    public function validateBirthPlace(string $birthPlace) : bool {
        // Italian city names don't contain any digits
        // No Italian city has a name made up of only one character
        return ((strlen($birthPlace) >= 2) && (!preg_match('/[0-9]/', $birthPlace)));
    }

    public function validateTelephoneNumber(string $telephoneNumber) : bool {
        // Italian telephone numbers are made up of exactly ten digits
        return ((strlen($telephoneNumber) === 10) && (ctype_digit($telephoneNumber)));
    }

    public function validateTaxCode(string $taxCode) : bool {
        $pattern = '/^[A-Z]{6}([0-2][0-9]|[0-9]{2})[ABCDEHLMPRST]([04][1-9]|[1256][0-9]|[37][01])[A-Z][0-9]{3}[A-Z]$/';
        return preg_match($pattern, $taxCode);
    }

    public function validateStreetAddress(string $streetAddress) : bool {
        $streetAddress = trim($streetAddress);
        // Italian street addresses cannot be shorter than six characters
        if(strlen($streetAddress) < 6) {
            return false;
        }
        // Italian street addresses cannot be made up of only numbers
        if(ctype_digit($streetAddress)) {
            return false;
        }
        // Italian street addresses must contain at least one space
        if(!strpos($streetAddress, ' ')) {
            return false;
        }
        return true;
    }

    public function validateHouseNumber(string $houseNumber) : bool {
        $pattern = '/^[0-9]{1,4}(\/?[a-zA-Z])?$/';
        return preg_match($pattern, $houseNumber);
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