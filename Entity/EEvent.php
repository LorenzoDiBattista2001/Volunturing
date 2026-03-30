<?php

class EEvent {
    
    private int $eventId;
    private string $title;
    private DateTime $dateAndTime;
    private string $place;
    private string $coordinator;
    private int $requestedVolunteerNumber;
    private int $maxVolunteerNumber;
    private EFieldOfAction $fieldOfAction;
    private ?string $candidateRequirements;
    private string $description;
    private array $applications;

    public function __construct(
        string $title,
        string $dateAndTime,
        string $place,
        string $coordinator,
        int $requestedVolunteerNumber,
        int $maxVolunteerNumber,
        string $fieldOfAction,
        ?string $candidateRequirements,
        string $description) 
    {
        if($requestedVolunteerNumber > $maxVolunteerNumber) {
            throw new Exception('The number of requested volunteers cannot
                            exceed the max volunteers\' number');
        }
        if(EFieldOfAction::tryFrom($fieldOfAction) === NULL) {
            throw new Exception('Invalid entry for attribute \'field of action\'');
        }
        $this->title = $title;
        $this->dateAndTime = new DateTime($dateAndTime);
        $this->place = $place;
        $this->coordinator = $coordinator;
        $this->requestedVolunteerNumber = $requestedVolunteerNumber;
        $this->maxVolunteerNumber = $maxVolunteerNumber;
        $this->fieldOfAction = EFieldOfAction::from($fieldOfAction);
        $this->candidateRequirements = $candidateRequirements;
        $this->description = $description;
        $this->applications = array();
    }

    // 'set' and 'get' methods

    public function setEventId(int $eventId) {
        $this->eventId = $eventId;
    }

    public function getEventId() : int {
        return $this->eventId;
    }

    public function setTitle(string $title) {
        $this->title = $title;
    }

    public function getTitle() : string {
        return $this->title;
    }

    public function setDateAndTime(string $dateAndTime) {
        $this->dateAndTime = new DateTime($dateAndTime);
    }

    public function getDateAndTime() : DateTime {
        return $this->dateAndTime;
    }

    public function setPlace(string $place) {
        $this->place = $place;
    }

    public function getPlace() : string {
        return $this->place;
    }

    public function setCoordinator(string $coordinator) {
        $this->coordinator = $coordinator;
    }

    public function getCoordinator() : string {
        return $this->coordinator;
    }

    public function setRequestedVolunteerNumber(int $requestedVolunteerNumber) {
        $this->requestedVolunteerNumber = $requestedVolunteerNumber;
    }

    public function getRequestedVolunteerNumber() : int {
        return $this->requestedVolunteerNumber;
    }

    public function setMaxVolunteerNumber(int $maxVolunteerNumber) {
        $this->maxVolunteerNumber = $maxVolunteerNumber;
    }

    public function getMaxVolunteerNumber() : int {
        return $this->maxVolunteerNumber;
    }

    public function setFieldOfAction(EFieldOfAction $fieldOfAction) {
        $this->fieldOfAction = $fieldOfAction;
    }

    public function getFieldOfAction() : EFieldOfAction {
        return $this->fieldOfAction;
    }

    public function setCandidateRequirements(?string $candidateRequirements) {
        $this->candidateRequirements = $candidateRequirements;
    }

    public function getCandidateRequirements() : ?string {
        return $this->candidateRequirements;
    }

    public function setDescription(string $description) {
        $this->description = $description;
    }

    public function getDescription() : string {
        return $this->description;
    }

    // methods for managing event's applications

    public function setApplications(array $applications) {
        $this->applications = $applications;
    }

    public function getApplications() {
        return $this->applications;
    }

    public function addApplication(EApplication $application) {
        $this->applications[] = $application;
    }

    public function getApprovedApplicationsNumber() : int {
        $count = 0;
        if(count($this->applications) === 0) return $count;
        
        foreach($this->applications as $application) {
            if($application->wasAccepted()) {
                $count++;
            }
        }
        return $count;
    }

    public function getPendingApplications() {
        $pendingApplications = array();

        foreach($this->applications as $application) {
            if($application->isPending()) {
                $pendingApplications[] = $application;
            }
        }

        return $pendingApplications;
    }

    public function getAcceptedApplications() {
        $acceptedApplications = array();

        foreach($this->applications as $application) {
            if($application->isApproved()) {
                $acceptedApplications[] = $application;
            }
        }

        return $acceptedApplications;
    }

    public function isFull() : bool {
        return ($this->maxVolunteerNumber === $this->getApprovedApplicationsNumber());
    }

    // additional methods

    public function isScheduled() : bool {
        return $this->getDateAndTime() > new DateTime('now');
    }

    public function getPendingApplicationsNumber() : int {
        return count($this->getPendingApplications());
    }

    public function getAcceptedApplicationsNumber() : int {
        return count($this->getAcceptedApplications());
    }

    public function getProgress() : int {
        $n = $this->getAcceptedApplicationsNumber();
        $d = $this->getMaxVolunteerNumber();

        return (int) (ceil(($n / $d) * 100));
    }
}

?>