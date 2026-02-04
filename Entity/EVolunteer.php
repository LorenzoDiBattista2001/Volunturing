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

    // 'set' and 'get' methods

    public function setBirthDate(string $birthDate) {
        $this->birthDate = new DateTime($birthDate);
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
        $this->streetAddress = $streetAddress;
    }

    public function getStreetAddress() : string {
        return $this->streetAddress;
    }

    public function setHouseNumber(string $houseNumber) {
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

    public function blockUser() {
        $this->isBlocked = true;
    }

    public function unlockUser() {
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
     
}

?>