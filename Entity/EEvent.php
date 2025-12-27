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
    private string $candidateRequirements;
    private array $applications = array();
}

?>