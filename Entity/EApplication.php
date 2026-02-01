<?php

class EApplication {

    private int $userId;
    private int $eventId;
    private DateTime $submittedDateTime;
    private EApplicationState $state;
    private ?string $message;
    private ?string $reasonForRejection = null;
    private bool $wasAccepted = false;
    private EVolunteer $candidate;
    private EEvent $event;

    public function __construct(
        string $submittedDateTime,
        EApplicationState $state,
        ?string $message) 
    {
        $this->submittedDateTime = new DateTime($submittedDateTime);
        $this->state = $state;
        $this->message = $message;
    }

    // 'set' and 'get' methods

    public function setSubmittedDateTime(string $submittedDateTime) {
        $this->submittedDateTime = new DateTime($submittedDateTime);
    }

    public function getSubmittedDateTime() : DateTime {
        return $this->submittedDateTime;
    }

    public function setState(EApplicationState $state) {
        $this->state = $state;
    }

    public function getState() : EApplicationState {
        return $this->state;
    }

    public function setMessage(?string $message) {
        $this->message = $message;
    }

    public function getMessage() : ?string {
        return $this->message;
    }

    public function setReasonForRejection(?string $reasonForRejection) {
        $this->reasonForRejection = $reasonForRejection;
    }

    public function getReasonForRejection() : ?string {
        return $this->reasonForRejection;
    }

    public function markAsAccepted() {
        $this->wasAccepted = true;
    }

    public function wasAccepted() : bool {
        return $this->wasAccepted;
    }

    public function setCandidate(EVolunteer $candidate) {
        $this->candidate = $candidate;
    }

    public function getCandidate() : EVolunteer {
        return $this->candidate;
    }

    public function setEvent(EEvent $event) {
        $this->event = $event;
    }

    public function getEvent() : EEvent {
        return $this->event;
    }

    public function setUserId(int $userId) {
        $this->userId = $userId;
    }

    public function getUserId() : int {
        return $this->userId;
    }

    public function setEventId(int $eventId) {
        $this->eventId = $eventId;
    }

    public function getEventId() : int {
        return $this->eventId;
    }
}

?>