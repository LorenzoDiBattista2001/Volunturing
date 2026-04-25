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
        $this->setMessage($message);
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
        if($message === '') {
            $this->message = null;
        } else {
            $this->message = $message;
        }
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

    // application management methods

    public function approve() : void {
        if($this->isPending() && !$this->getEvent()->isFull()) {
            $this->setState(EApplicationState::APPROVED);
            $this->markAsAccepted();
        } elseif($this->isWithdrawn()) {
            throw new Exception('This application has been withdrawn and cannot be approved');
        } elseif($this->isRejected()) {
            throw new Exception('This application was rejected and cannot be approved');
        }
        else {
            throw new Exception('This application cannot be approved');
        }
    }

    public function reject(string $reason) : void {
        if($this->isPending()) {
            $this->setState(EApplicationState::REJECTED);
            $this->setReasonForRejection($reason);
        } elseif($this->isApproved()) {
            throw new Exception('This application has been approved and cannot be rejected');
        } elseif($this->isWithdrawn()) {
            throw new Exception('This application was withdrawn by the candidate');
        } else {
            throw new Exception('This application has already been rejected');
        }
    }

    public function withdraw() : void {
        if($this->isWithdrawn()) {
            throw new Exception('La presente candidatura risulta già ritirata');
        } elseif($this->isRejected()) {
            throw new Exception('La presente candidatura è stata rifiutata: impossibile ritirarla');
        } else {
            $this->setState(EApplicationState::WITHDRAWN);
        }
    }

    public function isPending() : bool {
        return ($this->getState() === EApplicationState::WAITING);
    }

    public function isApproved() : bool {
        return ($this->getState() === EApplicationState::APPROVED);
    }

    public function isWithdrawn() : bool {
        return ($this->getState() === EApplicationState::WITHDRAWN);
    }

    public function isRejected() : bool {
        return ($this->getState() === EApplicationState::REJECTED);
    }
}

?>