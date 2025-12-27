<?php

class EApplication {

    private DateTime $submittedDateTime;
    private EApplicationState $state;
    private string $message;
    private string $reasonForRejection;
    private bool $wasAccepted = false;
    private EVolunteer $candidate;
}

?>