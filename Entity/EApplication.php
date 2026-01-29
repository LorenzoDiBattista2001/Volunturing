<?php

class EApplication {

    private DateTime $submittedDateTime;
    private EApplicationState $state;
    private ?string $message;
    private ?string $reasonForRejection;
    private bool $wasAccepted = false;
    private EVolunteer $candidate;

    public function __construct(
        string $submittedDateTime,
        EApplicationState $state,
        ?string $message,
        EVolunteer $candidate) 
    {
        $this->submittedDateTime = new DateTime($submittedDateTime);
        $this->state = $state;
        $this->message = $message;
        $this->candidate = $candidate;
    }
}

?>