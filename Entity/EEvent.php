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

    /**
     * Fetches the number of historically approved applications
     * 
     * This method calculates the number of 'historically approved
     * applications' in that it considers every application ever
     * approved by an admin, regardless of it having been withdrawn
     * by the candidate at a later time.
     * 
     * @return int $count The number of historically approved applications
     */
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

    /**
     * Fetches the event's pending applications, i.e. the applications whose
     * state is 'waiting'
     * 
     * @return array $pendingApplications The event's pending applications
     */
    public function getPendingApplications() {
        $pendingApplications = array();

        foreach($this->applications as $application) {
            if($application->isPending()) {
                $pendingApplications[] = $application;
            }
        }

        return $pendingApplications;
    }

    /**
     * Fetches the event's 'accepted' (or 'currently approved') applications, 
     * i.e. the applications which have been approved by an admin and have not 
     * been withdrawn by the candidate thereafter
     * 
     * @return array $acceptedApplications The event's 'currently approved' applications
     */
    public function getAcceptedApplications() {
        $acceptedApplications = array();

        foreach($this->applications as $application) {
            if($application->isApproved()) {
                $acceptedApplications[] = $application;
            }
        }

        return $acceptedApplications;
    }

    /**
     * Fetches the event's 'active' applications, i.e. the applications which have neither been
     * rejected by an admin nor withdrawn by the candidate
     * 
     * @return array The event's 'active' applications
     */
    public function getCurrentApplications() {
        return array_merge($this->getAcceptedApplications(), $this->getPendingApplications());
    }

    /**
     * Determines whether the event has reached the maximum number of historically 
     * approved applications
     * 
     * @return bool 
     */
    public function isFull() : bool {
        return ($this->maxVolunteerNumber === $this->getApprovedApplicationsNumber());
    }

    // additional methods

    /**
     * Determines whether the event is currently scheduled (i.e. does not belong 
     * in the past) or not
     * 
     * @return bool 
     */
    public function isScheduled() : bool {
        return $this->getDateAndTime() > new DateTime('now');
    }

    /**
     * Fetches the event's 'participants', i.e. the candidates whose applications have
     * been approved and not withdrawn thereafter
     * 
     * @return array $participants The event's participants
     */
    public function getParticipants() {
        $participants = array();
        $approvedApplications = $this->getAcceptedApplications();

        foreach($approvedApplications as $application) {
            $participants[] = $application->getCandidate();
        }

        return $participants;
    }

    /**
     * Fetches the number of pending applications
     * 
     * @return int The number of pending applications
     */
    public function getPendingApplicationsNumber() : int {
        return count($this->getPendingApplications());
    }

    /**
     * Fetches the number of 'currently approved' applications
     * 
     * This method calculates the number of 'accepted' (or 'currently approved')
     * applications, i.e. the number of the event's applications which have been approved by 
     * an admin and have not been withdrawn by the candidate thereafter.
     * 
     * @return int The number of 'currently approved' applications
     */
    public function getAcceptedApplicationsNumber() : int {
        return count($this->getAcceptedApplications());
    }

    /**
     * Determines how many 'empty slots' are left until the
     * maximum number of volunteers is reached
     * 
     * This is a 'utility method' for HTML presentation purposes
     * 
     * @return int The number of applications which may still be approved
     */
    public function getEmptySlotsNumber() : int {
        return ($this->getMaxVolunteerNumber() - $this->getAcceptedApplicationsNumber());
    }

    /**
     * Determines the ratio (as a percentage) of the 'currently approved' 
     * applications to the maximum volunteers number
     * 
     * This is a 'utility method' for HTML presentation purposes
     * 
     * @return int
     */
    public function getProgress() : int {
        $n = $this->getAcceptedApplicationsNumber();
        $d = $this->getMaxVolunteerNumber();

        return (int) (ceil(($n / $d) * 100));
    }
}

?>